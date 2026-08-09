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
 * directly (see PaymentPolicy and PaymentForm).
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
}
