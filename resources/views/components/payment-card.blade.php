@props(['payment'])
<div class="flex items-center justify-between rounded-lg border border-slate-100 px-4 py-3">
    <div>
        <p class="text-sm font-semibold text-ink">{{ $payment->payment_code }}</p>
        <p class="text-xs text-muted">{{ ucfirst(str_replace('_',' ',$payment->method)) }} &middot; {{ optional($payment->paid_at)->format('d M Y, H:i') ?? '—' }}</p>
    </div>
    <div class="text-right">
        <p class="font-semibold text-ink">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        <x-status-badge :status="$payment->status" class="mt-1" />
    </div>
</div>
