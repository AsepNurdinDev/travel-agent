<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('invoices.view');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->can('invoices.view');
    }

    public function create(User $user): bool
    {
        // Invoices are generated automatically by BookingService when a
        // booking is created — no manual create form.
        return false;
    }

    public function update(User $user, Invoice $invoice): bool
    {
        // Only notes/due_date are editable; status is derived from payments
        // via InvoiceService::syncStatusFromBooking(), never hand-edited.
        return $user->can('invoices.update');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return false;
    }

    public function restore(User $user, Invoice $invoice): bool
    {
        return false;
    }

    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
