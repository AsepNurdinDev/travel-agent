<?php

namespace App\Services\Payment;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\Invoice\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

/**
 * The ONLY class allowed to mark a payment as paid/refunded and update a
 * booking's amount_paid. Filament's PaymentResource must call through here
 * rather than letting an admin free-edit amount/status/paid_at/transaction_id
 * directly (see PaymentPolicy and PaymentForm). Same rule applies to the
 * Midtrans gateway flow below — MidtransGateway never touches Booking/Payment
 * directly, it only hands normalized data to this service.
 */
class PaymentService
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
    ) {
    }

    /**
     * Record a manual payment (e.g. bank transfer confirmed by finance staff)
     * against a booking. Amount is always validated against the outstanding
     * balance — a payment can never overpay a booking.
     */
    public function recordManualPayment(
        Booking $booking,
        float $amount,
        string $method,
        ?int $verifiedByUserId = null,
        ?string $transactionId = null,
    ): Payment {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        return DB::transaction(function () use ($booking, $amount, $method, $verifiedByUserId, $transactionId) {
            /** @var Booking $locked */
            $locked = Booking::query()->whereKey($booking->id)->lockForUpdate()->firstOrFail();

            $balanceDue = bcsub((string) $locked->total_amount, (string) $locked->amount_paid, 2);

            if (bccomp((string) $amount, $balanceDue, 2) > 0) {
                throw new RuntimeException('Payment amount exceeds the outstanding balance for this booking.');
            }

            $payment = Payment::query()->create([
                'booking_id' => $locked->id,
                'payment_code' => 'PAY-'.now()->format('ymd').'-'.strtoupper(Str::random(6)),
                'amount' => $amount,
                'method' => $method,
                'status' => 'paid',
                'transaction_id' => $transactionId,
                'paid_at' => now(),
                'verified_by' => $verifiedByUserId,
            ]);

            $locked->amount_paid = bcadd((string) $locked->amount_paid, (string) $amount, 2);

            if ($locked->status === 'pending' && bccomp($locked->amount_paid, '0.00', 2) > 0) {
                $locked->status = 'confirmed';
            }

            $locked->save();

            $this->invoiceService->syncStatusFromBooking($locked);

            return $payment;
        });
    }

    public function refundPayment(Payment $payment): Payment
    {
        if ($payment->status !== 'paid') {
            throw new RuntimeException('Only a paid payment can be refunded.');
        }

        return DB::transaction(function () use ($payment) {
            $booking = Booking::query()->whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();

            $payment->update(['status' => 'refunded']);

            $booking->amount_paid = max('0.00', bcsub((string) $booking->amount_paid, (string) $payment->amount, 2));
            $booking->save();

            $this->invoiceService->syncStatusFromBooking($booking);

            return $payment->fresh();
        });
    }

    /**
     * Buat Payment berstatus 'pending' untuk memulai transaksi Midtrans.
     * Tidak menyentuh amount_paid booking sama sekali — itu baru terjadi
     * saat confirmGatewayPayment() dipanggil dari webhook yang sudah
     * terverifikasi.
     */
    public function createPendingGatewayPayment(
        Booking $booking,
        float $amount,
        string $method = 'other',
    ): Payment {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Payment amount must be greater than zero.');
        }

        return DB::transaction(function () use ($booking, $amount, $method) {
            /** @var Booking $locked */
            $locked = Booking::query()->whereKey($booking->id)->lockForUpdate()->firstOrFail();

            $balanceDue = bcsub((string) $locked->total_amount, (string) $locked->amount_paid, 2);

            if (bccomp((string) $amount, $balanceDue, 2) > 0) {
                throw new RuntimeException('Payment amount exceeds the outstanding balance for this booking.');
            }

            return Payment::query()->create([
                'booking_id' => $locked->id,
                'payment_code' => 'PAY-'.now()->format('ymd').'-'.strtoupper(Str::random(6)),
                'amount' => $amount,
                'method' => $method,
                'status' => 'pending',
            ]);
        });
    }

    /**
     * Konfirmasi pembayaran dari hasil MidtransGateway::handleWebhook()
     * yang SUDAH terverifikasi signature-nya. $result punya bentuk:
     * ['transaction_id' => payment_code, 'status' => paid|pending|failed|refunded, 'raw' => payload]
     *
     * Idempotent: notifikasi yang sama/terlambat dari Midtrans tidak akan
     * menggandakan amount_paid atau memundurkan status yang sudah final.
     */
    public function confirmGatewayPayment(array $result): Payment
    {
        $paymentCode = $result['transaction_id'] ?? null;
        $incomingStatus = $result['status'] ?? null;
        $raw = $result['raw'] ?? [];

        if (! $paymentCode || ! $incomingStatus) {
            throw new RuntimeException('Incomplete gateway confirmation payload.');
        }

        return DB::transaction(function () use ($paymentCode, $incomingStatus, $raw) {
            /** @var Payment|null $payment */
            $payment = Payment::query()->where('payment_code', $paymentCode)->lockForUpdate()->first();

            if (! $payment) {
                throw new RuntimeException("No local payment found for order_id [{$paymentCode}].");
            }

            // Notifikasi duplikat dengan status final yang sama -> jangan proses ulang.
            if (in_array($payment->status, ['paid', 'failed', 'refunded'], true) && $payment->status === $incomingStatus) {
                $payment->update(['gateway_response' => $raw]);

                return $payment;
            }

            // Payment sudah 'paid' secara lokal -> notifikasi 'pending' yang telat tidak boleh memundurkan status.
            if ($payment->status === 'paid' && $incomingStatus === 'pending') {
                $payment->update(['gateway_response' => $raw]);

                return $payment;
            }

            $midtransTransactionId = $raw['transaction_id'] ?? $payment->transaction_id;
            $method = $this->mapGatewayMethod($raw['payment_type'] ?? null) ?? $payment->method;

            if ($incomingStatus === 'paid') {
                /** @var Booking $booking */
                $booking = Booking::query()->whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();

                $payment->update([
                    'status' => 'paid',
                    'transaction_id' => $midtransTransactionId,
                    'method' => $method,
                    'paid_at' => now(),
                    'gateway_response' => $raw,
                ]);

                $booking->amount_paid = bcadd((string) $booking->amount_paid, (string) $payment->amount, 2);

                if ($booking->status === 'pending') {
                    $booking->status = 'confirmed';
                }

                $booking->save();

                $this->invoiceService->syncStatusFromBooking($booking);
            } elseif ($incomingStatus === 'failed') {
                $payment->update([
                    'status' => 'failed',
                    'transaction_id' => $midtransTransactionId,
                    'method' => $method,
                    'gateway_response' => $raw,
                ]);
                // amount_paid booking tidak disentuh — memang belum pernah ditambahkan.
            } elseif ($incomingStatus === 'refunded') {
                if ($payment->status !== 'paid') {
                    // Tidak bisa refund payment yang secara lokal belum pernah 'paid'.
                    $payment->update(['gateway_response' => $raw]);

                    return $payment;
                }

                /** @var Booking $booking */
                $booking = Booking::query()->whereKey($payment->booking_id)->lockForUpdate()->firstOrFail();

                $payment->update([
                    'status' => 'refunded',
                    'gateway_response' => $raw,
                ]);

                $booking->amount_paid = max('0.00', bcsub((string) $booking->amount_paid, (string) $payment->amount, 2));
                $booking->save();

                $this->invoiceService->syncStatusFromBooking($booking);
            } else {
                // masih 'pending' — cuma update jejak data, belum ada mutasi keuangan.
                $payment->update([
                    'transaction_id' => $midtransTransactionId,
                    'method' => $method,
                    'gateway_response' => $raw,
                ]);
            }

            return $payment->fresh();
        });
    }

    /**
     * Memetakan payment_type dari Midtrans ke enum method Payment kita.
     */
    private function mapGatewayMethod(?string $paymentType): ?string
    {
        return match ($paymentType) {
            'credit_card' => 'credit_card',
            'bank_transfer', 'echannel', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va' => 'bank_transfer',
            'gopay', 'shopeepay', 'qris' => 'e_wallet',
            default => null,
        };
    }
}