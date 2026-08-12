<x-app-layout title="Invoice Detail">
    @php $booking = $invoice->booking; @endphp

    <a href="{{ route('account.invoices') }}" class="inline-flex items-center gap-1.5 text-sm text-muted hover:text-primary mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Invoices
    </a>

    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-5">
            <div>
                <p class="text-xs text-muted">Invoice Number</p>
                <p class="font-mono font-bold text-ink text-lg">{{ $invoice->invoice_number }}</p>
            </div>
            <x-status-badge :status="$invoice->status" class="text-sm" />
        </div>

        <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div><p class="text-muted">Booking</p><p class="font-medium text-ink">{{ $booking->booking_code }}</p></div>
            <div><p class="text-muted">Tour</p><p class="font-medium text-ink">{{ $booking->tourPackage->name ?? '—' }}</p></div>
            <div><p class="text-muted">Issued</p><p class="font-medium text-ink">{{ $invoice->issued_date->format('d M Y') }}</p></div>
            <div><p class="text-muted">Due Date</p><p class="font-medium text-ink">{{ optional($invoice->due_date)->format('d M Y') ?? '—' }}</p></div>
        </div>

        @if ($invoice->notes)
            <div class="mt-5 border-t border-slate-100 pt-5">
                <p class="text-sm text-muted">{{ $invoice->notes }}</p>
            </div>
        @endif
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-price-breakdown :booking="$booking" />

        <div class="card p-6">
            <h3 class="font-bold text-ink">Payment History</h3>
            <div class="mt-4 space-y-2">
                @forelse ($booking->payments as $payment)
                    <x-payment-card :payment="$payment" />
                @empty
                    <p class="text-sm text-muted">No payments recorded yet.</p>
                @endforelse
            </div>

            @if ((float) $booking->balance_due > 0 && ! in_array($booking->status, ['cancelled']))
                <a href="{{ route('booking.checkout', $booking) }}" class="btn-accent w-full mt-4">Pay Remaining Balance</a>
            @endif
        </div>
    </div>
</x-app-layout>
