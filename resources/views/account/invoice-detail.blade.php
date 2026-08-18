<x-app-layout title="Detail Tagihan">
    @php $booking = $invoice->booking; @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Back Navigation --}}
        <div>
            <a href="{{ route('account.invoices') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Daftar Tagihan</span>
            </a>
        </div>

        {{-- Main Invoice Info Card --}}
        <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm space-y-6">
            
            {{-- Header: Invoice Number & Status --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Tagihan</span>
                    <h1 class="font-mono font-extrabold text-slate-900 text-xl sm:text-2xl mt-0.5">{{ $invoice->invoice_number }}</h1>
                </div>
                <div class="self-start sm:self-auto">
                    <x-status-badge :status="$invoice->status" class="text-sm" />
                </div>
            </div>

            {{-- Metadata Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Kode Booking</p>
                    <p class="font-mono font-bold text-slate-900 text-sm mt-0.5 truncate">{{ $booking->booking_code }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Paket Wisata</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5 line-clamp-1">{{ $booking->tourPackage->name ?? '—' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Tanggal Terbit</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $invoice->issued_date->format('d M Y') }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Tenggat Pembayaran</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">{{ optional($invoice->due_date)->format('d M Y') ?? '—' }}</p>
                </div>
            </div>

            {{-- Notes Notice --}}
            @if ($invoice->notes)
                <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 text-xs text-slate-600 leading-relaxed">
                    <span class="font-bold text-slate-800">Catatan Tagihan:</span> {{ $invoice->notes }}
                </div>
            @endif
        </div>

        {{-- Breakdown & Payment History Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            {{-- Price Breakdown Component --}}
            <x-price-breakdown :booking="$booking" />

            {{-- Payment History Card --}}
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-900">Riwayat Pembayaran</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar pembayaran yang telah dilakukan untuk pesanan ini.</p>
                </div>

                <div class="space-y-2.5">
                    @forelse ($booking->payments as $payment)
                        <x-payment-card :payment="$payment" />
                    @empty
                        <div class="rounded-2xl bg-slate-50 p-6 text-center text-xs text-slate-400 border border-slate-100">
                            Belum ada riwayat pembayaran yang tercatat.
                        </div>
                    @endforelse
                </div>

                {{-- Pay Balance Action --}}
                @if ((float) $booking->balance_due > 0 && !in_array($booking->status, ['cancelled']))
                    <div class="pt-2 border-t border-slate-100">
                        <a href="{{ route('booking.checkout', $booking) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 py-3.5 text-xs font-bold text-white shadow-md hover:bg-amber-600 transition">
                            <span>Bayar Sisa Pelunasan (Rp {{ number_format($booking->balance_due, 0, ',', '.') }})</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>