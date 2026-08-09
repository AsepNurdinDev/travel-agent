<?php

namespace App\Services\Payment\Gateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Payment;
use RuntimeException;

/**
 * Placeholder Midtrans driver.
 *
 * Intentionally NOT wired up to the real Midtrans API yet — implementing
 * the live payment gateway is explicitly out of scope for this pass.
 * This class only exists so PaymentService can be constructed against
 * PaymentGatewayInterface today without a hard dependency on Midtrans.
 */
class MidtransGateway implements PaymentGatewayInterface
{
    public function charge(Payment $payment): array
    {
        throw new RuntimeException('Midtrans integration is not implemented yet.');
    }

    public function handleWebhook(array $payload): array
    {
        throw new RuntimeException('Midtrans integration is not implemented yet.');
    }

    public function getStatus(string $transactionId): string
    {
        throw new RuntimeException('Midtrans integration is not implemented yet.');
    }
}
