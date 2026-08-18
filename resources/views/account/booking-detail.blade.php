<x-app-layout title="Detail Pesanan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Back Navigation --}}
        <div>
            <a href="{{ route('account.bookings') }}" 
               class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200 hover:text-slate-900 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Pesanan Saya</span>
            </a>
        </div>

        {{-- Main Booking Info Card --}}
        <div class="rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm space-y-6">
            
            {{-- Header: Booking Code, Tour Title & Status --}}
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-slate-100 pb-6">
                <div class="space-y-1">
                    <span class="font-mono text-xs font-extrabold tracking-wider text-emerald-600 uppercase">
                        {{ $booking->booking_code }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ $booking->tourPackage->name }}
                    </h1>
                </div>
                <div class="self-start sm:self-auto">
                    <x-status-badge :status="$booking->status" class="text-sm" />
                </div>
            </div>

            {{-- Metadata Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Destinasi</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5 truncate">
                        {{ $booking->tourPackage->destination->name ?? '—' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Keberangkatan</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">
                        {{ optional($booking->availability)->departure_date?->format('d M Y') ?? '—' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Kepulangan</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">
                        {{ optional($booking->availability)->return_date?->format('d M Y') ?? '—' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100/80">
                    <p class="text-slate-400 font-medium">Tanggal Dipesan</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">
                        {{ $booking->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Participants Section --}}
            <div class="border-t border-slate-100 pt-5 space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Jumlah Peserta</h3>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-3 py-1.5 font-medium text-slate-700">
                        <span>Dewasa:</span>
                        <strong class="text-slate-900 font-extrabold">{{ $booking->adult_count }}</strong>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-3 py-1.5 font-medium text-slate-700">
                        <span>Anak-anak:</span>
                        <strong class="text-slate-900 font-extrabold">{{ $booking->child_count }}</strong>
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-3 py-1.5 font-medium text-slate-700">
                        <span>Bayi:</span>
                        <strong class="text-slate-900 font-extrabold">{{ $booking->infant_count }}</strong>
                    </span>
                </div>
            </div>

            {{-- Add-ons Section --}}
            @if ($booking->items->isNotEmpty())
                <div class="border-t border-slate-100 pt-5 space-y-2.5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Layanan Tambahan (Add-ons)</h3>
                    <ul class="space-y-2 text-xs divide-y divide-slate-100">
                        @foreach ($booking->items as $item)
                            <li class="flex items-center justify-between pt-2 first:pt-0 text-slate-600 font-medium">
                                <span>{{ $item->name }} <span class="text-slate-400 font-bold">&times; {{ $item->quantity }}</span></span>
                                <span class="font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Notes Section --}}
            @if ($booking->notes)
                <div class="border-t border-slate-100 pt-5 space-y-1.5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Catatan Pesanan</h3>
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 text-xs text-slate-600 leading-relaxed">
                        {{ $booking->notes }}
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            @if (!in_array($booking->status, ['cancelled', 'completed']))
                <div class="border-t border-slate-100 pt-5 flex flex-wrap items-center gap-3">
                    @if ((float) $booking->balance_due > 0)
                        <a href="{{ route('booking.checkout', $booking) }}" 
                           class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-amber-600 transition">
                            <span>Bayar Sisa Pelunasan</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @endif

                    <form method="POST" 
                          action="{{ route('account.bookings.cancel', $booking) }}"
                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50/50 px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-100 hover:border-rose-300 transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- Breakdown & Payment History Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            {{-- Price Breakdown Component --}}
            <x-price-breakdown :booking="$booking" />

            {{-- Payment History Card --}}
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Riwayat Pembayaran</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar transaksi untuk pesanan ini.</p>
                    </div>
                    @if ($booking->invoice)
                        <a href="{{ route('account.invoices.show', $booking->invoice) }}" 
                           class="text-xs font-bold text-emerald-600 hover:underline">
                            Lihat Tagihan &rarr;
                        </a>
                    @endif
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
            </div>

        </div>

    </div>
</x-app-layout>