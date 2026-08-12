@props(['booking'])
<div class="card p-6">
    <h3 class="font-bold text-ink">Price Breakdown</h3>
    <div class="mt-4 space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-muted">Adults × {{ $booking->adult_count }}</span><span>Rp {{ number_format($booking->price_adult * $booking->adult_count, 0, ',', '.') }}</span></div>
        @if ($booking->child_count > 0)
            <div class="flex justify-between"><span class="text-muted">Children × {{ $booking->child_count }}</span><span>Rp {{ number_format($booking->price_child * $booking->child_count, 0, ',', '.') }}</span></div>
        @endif
        @if ($booking->infant_count > 0)
            <div class="flex justify-between"><span class="text-muted">Infants × {{ $booking->infant_count }}</span><span>Rp {{ number_format($booking->price_infant * $booking->infant_count, 0, ',', '.') }}</span></div>
        @endif
        @if ($booking->addons_total > 0)
            <div class="flex justify-between"><span class="text-muted">Add-ons</span><span>Rp {{ number_format($booking->addons_total, 0, ',', '.') }}</span></div>
        @endif
        <div class="flex justify-between border-t border-slate-100 pt-2"><span class="text-muted">Subtotal</span><span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span></div>
        @if ($booking->discount_amount > 0)
            <div class="flex justify-between text-emerald-600"><span>Discount{{ $booking->promotion ? ' ('.$booking->promotion->code.')' : '' }}</span><span>- Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</span></div>
        @endif
        <div class="flex justify-between border-t border-slate-100 pt-3 text-base font-bold text-ink">
            <span>Total</span><span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-emerald-600"><span>Amount Paid</span><span>Rp {{ number_format($booking->amount_paid, 0, ',', '.') }}</span></div>
        <div class="flex justify-between font-semibold text-ink"><span>Balance Due</span><span>Rp {{ number_format($booking->balance_due, 0, ',', '.') }}</span></div>
    </div>
</div>
