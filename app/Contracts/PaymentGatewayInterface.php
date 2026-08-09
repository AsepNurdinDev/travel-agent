<?php

namespace App\Contracts;

use App\Models\Payment;

/**
 * Contract every payment gateway driver must implement.
 *
 * Scope note: no gateway is wired to a real API yet (Midtrans integration
 * is explicitly out of scope for this pass). This contract exists so
 * PaymentService can depend on an abstraction instead of a concrete
 * gateway, per the intended architecture.
 */
interface PaymentGatewayInterface
{
    /**
     * Start a payment transaction for the given booking amount and return
     * gateway-specific data (e.g. redirect URL / token) the frontend needs.
     *
     * @return array<string, mixed>
     */
    public function charge(Payment $payment): array;

    /**
     * Verify and normalize an inbound webhook/notification payload from the
     * gateway into a small, predictable shape the app can trust.
     *
     * @param  array<string, mixed>  $payload
     * @return array{transaction_id: string, status: string, raw: array<string, mixed>}
     */
    public function handleWebhook(array $payload): array;

    /**
     * Query the current status of a transaction directly from the gateway.
     */
    public function getStatus(string $transactionId): string;
}
