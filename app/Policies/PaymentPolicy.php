<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

/**
 * Payments are sensitive financial records. There is deliberately no
 * generic "edit any field" path: the Filament form only exposes a
 * "confirm payment" / "refund" action that routes through PaymentService,
 * never a raw amount/status/transaction_id/paid_at input. See
 * app/Filament/Resources/Payments/Schemas/PaymentForm.php.
 */
class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('payments.view');
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->can('payments.view');
    }

    public function create(User $user): bool
    {
        // Payments are created only through BookingService/PaymentService
        // (e.g. the "Record Payment" action on a booking), never a bare
        // create form — see PaymentResource::canCreate().
        return false;
    }

    public function update(User $user, Payment $payment): bool
    {
        // "Update" here only ever means the confirm/refund action, gated by
        // the payments.update permission (finance + admin + super_admin).
        return $user->can('payments.update');
    }

    public function delete(User $user, Payment $payment): bool
    {
        // Payments are never deleted, only refunded, to preserve the audit trail.
        return false;
    }

    public function restore(User $user, Payment $payment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Payment $payment): bool
    {
        return false;
    }
}
