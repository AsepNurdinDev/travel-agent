<x-app-layout title="Booking Confirmed">
<div class="container-page py-16">
    <div class="mx-auto max-w-2xl text-center">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </span>
        <h1 class="mt-5 text-2xl sm:text-3xl font-bold text-ink">Booking Confirmed!</h1>
        <p class="mt-2 text-muted">Your adventure to {{ $booking->tourPackage->name }} is all set. A confirmation has been sent to your email.</p>
    </div>

    <div class="mx-auto mt-10 max-w-2xl card p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <p class="text-xs text-muted">Booking Number</p>
                <p class="font-mono font-bold text-ink">{{ $booking->booking_code }}</p>
            </div>
            <x-status-badge :status="$booking->status" />
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-muted">Tour</p><p class="font-medium text-ink">{{ $booking->tourPackage->name }}</p></div>
            <div><p class="text-muted">Departure</p><p class="font-medium text-ink">{{ $booking->availability->departure_date->format('d M Y') }}</p></div>
            <div><p class="text-muted">Participants</p><p class="font-medium text-ink">{{ $booking->adult_count + $booking->child_count + $booking->infant_count }} travelers</p></div>
            <div><p class="text-muted">Payment Status</p><x-status-badge :status="$booking->invoice->status ?? 'unpaid'" /></div>
        </div>

        <div class="mt-5 border-t border-slate-100 pt-4 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-muted">Total</span><span class="font-medium text-ink">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span class="text-muted">Amount Paid</span><span class="font-medium text-emerald-600">Rp {{ number_format($booking->amount_paid, 0, ',', '.') }}</span></div>
            <div class="flex justify-between text-base font-bold"><span>Remaining Balance</span><span>Rp {{ number_format($booking->balance_due, 0, ',', '.') }}</span></div>
        </div>
    </div>

    <div class="mx-auto mt-8 flex max-w-2xl flex-col sm:flex-row justify-center gap-3">
        <a href="{{ route('account.bookings.show', $booking) }}" class="btn-primary">View Booking</a>
        @if ($booking->invoice)
            <a href="{{ route('account.invoices.show', $booking->invoice) }}" class="btn-outline">View Invoice</a>
        @endif
        <a href="{{ route('home') }}" class="btn-ghost">Back to Home</a>
    </div>
</div>
</x-app-layout>
