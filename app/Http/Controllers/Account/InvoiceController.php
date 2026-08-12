<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $customer = Auth::user()->customer;

        $invoices = Invoice::query()
            ->whereHas('booking', fn ($q) => $q->where('customer_id', $customer?->id ?? 0))
            ->with(['booking.tourPackage'])
            ->latest()
            ->paginate(10);

        return view('account.invoices', compact('invoices'));
    }

    public function show(Invoice $invoice): View
    {
        $customer = Auth::user()->customer;

        abort_if(! $customer || $invoice->booking->customer_id !== $customer->id, 403);

        $invoice->load(['booking.tourPackage.destination', 'booking.availability', 'booking.payments', 'booking.items']);

        return view('account.invoice-detail', compact('invoice'));
    }
}
