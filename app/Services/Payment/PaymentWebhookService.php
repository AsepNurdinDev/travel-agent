<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Entry point for gateway webhook notifications. Route handler calls
 * handle() dan cukup percaya hasilnya — semua verifikasi signature dan
 * mutasi keuangan sudah didelegasikan ke gateway + PaymentService.
 */
class PaymentWebhookService
{
    public function __construct(
        private readonly PaymentGatewayInterface $gateway,
        private readonly PaymentService $paymentService,
    ) {
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function handle(array $payload): void
    {
        try {
            $result = $this->gateway->handleWebhook($payload);
        } catch (Throwable $e) {
            Log::warning('Midtrans webhook rejected: '.$e->getMessage(), ['payload' => $payload]);

            throw $e;
        }

        $this->paymentService->confirmGatewayPayment($result);
    }
}