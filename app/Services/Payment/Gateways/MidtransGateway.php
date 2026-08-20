<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use RuntimeException;
use Throwable;

/**
 * Midtrans Snap driver.
 *
 * charge()        -> membuat transaksi Snap, mengembalikan snap_token untuk popup.
 * handleWebhook()  -> verifikasi signature notifikasi, normalisasi status.
 * getStatus()      -> query status transaksi langsung ke Midtrans (manual/CLI).
 */
class MidtransGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        $this->configure();
    }

    private function configure(): void
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }

    public function charge(Payment $payment): array
    {
        $payment->loadMissing('booking.customer');

        $booking = $payment->booking;
        $customer = $booking->customer;

        $grossAmount = (int) round((float) $payment->amount);

        if ($grossAmount <= 0) {
            throw new RuntimeException('Nominal pembayaran tidak valid untuk diproses ke Midtrans.');
        }

        $params = [
            'transaction_details' => [
                'order_id' => $payment->payment_code,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
            'callbacks' => [
                'finish' => route('booking.success', $booking),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (Throwable $e) {
            throw new RuntimeException('Gagal membuat transaksi Midtrans: '.$e->getMessage(), previous: $e);
        }

        return [
            'snap_token' => $snapToken,
            'order_id' => $payment->payment_code,
            'client_key' => (string) config('services.midtrans.client_key'),
        ];
    }

    /**
     * Verifikasi payload notifikasi Midtrans lalu normalisasi jadi bentuk
     * yang dipercaya PaymentService.
     *
     * PENTING soal 'transaction_id' yang dikembalikan di sini: nilainya
     * adalah order_id (= payment_code kita), BUKAN transaction_id asli
     * dari Midtrans. Ini sengaja — payment_code adalah satu-satunya kunci
     * yang unik & kita kontrol sendiri untuk mencari record Payment lokal.
     * transaction_id asli dari Midtrans tetap tersimpan utuh di dalam
     * 'raw', dan akan disimpan ke kolom Payment::transaction_id di
     * Tahap 4 untuk keperluan audit.
     */
    public function handleWebhook(array $payload): array
    {
        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        if ($orderId === '' || $signatureKey === '') {
            throw new RuntimeException('Payload notifikasi Midtrans tidak lengkap.');
        }

        $expectedSignature = hash(
            'sha512',
            $orderId.$statusCode.$grossAmount.(string) config('services.midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $signatureKey)) {
            throw new RuntimeException('Signature notifikasi Midtrans tidak valid — payload ditolak.');
        }

        $transactionStatus = (string) ($payload['transaction_status'] ?? '');
        $fraudStatus = (string) ($payload['fraud_status'] ?? 'accept');

        return [
            'transaction_id' => $orderId,
            'status' => $this->mapTransactionStatus($transactionStatus, $fraudStatus),
            'raw' => $payload,
        ];
    }

    /**
     * Memetakan status Midtrans ke enum status Payment kita
     * (pending, paid, failed, refunded).
     */
    private function mapTransactionStatus(string $transactionStatus, string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'failed',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'failed',
            'refund', 'partial_refund' => 'refunded',
            default => 'pending',
        };
    }

    public function getStatus(string $transactionId): string
    {
        try {
            $status = Transaction::status($transactionId);
        } catch (Throwable $e) {
            throw new RuntimeException('Gagal mengambil status transaksi Midtrans: '.$e->getMessage(), previous: $e);
        }

        return $status->transaction_status ?? 'unknown';
    }
}