@props(['invoice'])

<a href="{{ route('account.invoices.show', $invoice) }}" 
   class="group block rounded-2xl border border-slate-100 bg-white p-4.5 sm:p-5 shadow-sm transition-all duration-200 hover:border-slate-200 hover:shadow-md">
    <div class="flex items-center justify-between gap-4">
        
        {{-- Left Info Section --}}
        <div class="min-w-0 space-y-1">
            <div class="flex items-center gap-2">
                <span class="font-mono text-sm font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors">
                    {{ $invoice->invoice_number }}
                </span>
            </div>

            <p class="text-xs font-semibold text-slate-600 truncate">
                {{ $invoice->booking->tourPackage->name ?? '—' }}
            </p>

            <p class="text-[11px] text-slate-400 font-medium flex items-center gap-1.5 flex-wrap">
                <span>Terbit: {{ $invoice->issued_date->format('d M Y') }}</span>
                @if($invoice->due_date)
                    <span class="text-slate-300">&middot;</span>
                    <span>Tenggat: {{ $invoice->due_date->format('d M Y') }}</span>
                @endif
            </p>
        </div>

        {{-- Right Price & Status Section --}}
        <div class="text-right shrink-0">
            <p class="text-sm sm:text-base font-extrabold text-slate-900">
                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
            </p>
            <div class="mt-1 flex justify-end">
                <x-status-badge :status="$invoice->status" class="text-[11px]" />
            </div>
        </div>

    </div>
</a>