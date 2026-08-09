<?php

namespace App\Services\Invoice;

use App\Models\Booking;
use App\Models\Invoice;

class InvoiceService
{
    public function createForBooking(Booking $booking, int $dueInDays = 3): Invoice
    {
        return Invoice::query()->create([
            'booking_id' => $booking->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'issued_date' => now(),
            'due_date' => now()->addDays($dueInDays),
            'amount' => $booking->total_amount,
            'status' => 'unpaid',
        ]);
    }

    /**
     * Recompute invoice status from the booking's actual paid amount.
     * Called by PaymentService whenever a payment is confirmed/refunded —
     * this is the only place invoice.status may change.
     */
    public function syncStatusFromBooking(Booking $booking): void
    {
        $invoice = $booking->invoice;

        if (! $invoice) {
            return;
        }

        if (bccomp((string) $booking->amount_paid, (string) $booking->total_amount, 2) >= 0) {
            $status = 'paid';
        } elseif (bccomp((string) $booking->amount_paid, '0.00', 2) > 0) {
            $status = 'partially_paid';
        } else {
            $status = 'unpaid';
        }

        $invoice->update(['status' => $status]);
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-'.now()->format('Ymd').'-';

        $last = Invoice::query()
            ->where('invoice_number', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->first();

        $sequence = $last ? ((int) substr($last->invoice_number, -4)) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
