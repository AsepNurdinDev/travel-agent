<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use RuntimeException;

/**
 * Entry point for gateway webhook notifications. Not wired to a live route
 * yet (production webhook handling is out of scope for this pass) — this
 * class only defines how an incoming payload will be validated and routed
 * to PaymentService once a real gateway is connected.
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
        // Intentionally not implemented — payment gateway integration is
        // out of scope for this pass. When implemented, this must verify
        // the payload signature via $this->gateway->handleWebhook() before
        // trusting anything in it, then confirm the matching Payment
        // through PaymentService rather than writing to it directly.
        throw new RuntimeException('Payment webhook handling is not implemented yet.');
    }
}
