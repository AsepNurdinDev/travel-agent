@props(['invoice'])
<a href="{{ route('account.invoices.show', $invoice) }}" class="card flex items-center justify-between p-4 hover:shadow-lg transition">
    <div class="min-w-0">
        <p class="font-mono text-sm font-semibold text-ink">{{ $invoice->invoice_number }}</p>
        <p class="text-xs text-muted truncate">{{ $invoice->booking->tourPackage->name ?? '' }}</p>
        <p class="text-xs text-muted mt-0.5">Issued {{ $invoice->issued_date->format('d M Y') }} @if($invoice->due_date) &middot; Due {{ $invoice->due_date->format('d M Y') }} @endif</p>
    </div>
    <div class="text-right shrink-0 ml-4">
        <p class="font-semibold text-ink">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
        <x-status-badge :status="$invoice->status" class="mt-1" />
    </div>
</a>
