<x-app-layout title="Pembayaran">
@php
    $balanceDue = (float) $booking->balance_due;
    $depositAmount = round(max($balanceDue * 0.3, min($balanceDue, 100000)), 2);
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ paymentType: 'full', method: 'bank_transfer' }">
    <div class="mx-auto max-w-5xl">
        
        {{-- Breadcrumb Steps --}}
        <div class="mb-8 flex items-center gap-2.5 text-xs font-semibold">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-emerald-700 border border-emerald-200/60">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Pesanan Dibuat
            </span>
            <svg class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="inline-flex items-center rounded-full bg-emerald-600 px-3 py-1 text-white shadow-sm">
                Pembayaran
            </span>
            <svg class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-slate-400">
                Konfirmasi
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
            
            {{-- Main Form Area --}}
            <div class="lg:col-span-3 space-y-6">
                
                {{-- Tour & Booking Info Summary Card --}}
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Paket Wisata</span>
                            <h2 class="text-lg font-bold text-slate-900 mt-0.5">{{ $booking->tourPackage->name }}</h2>
                            <p class="text-xs text-slate-500 mt-1">Kode Pesanan: <span class="font-mono font-bold text-slate-900">{{ $booking->booking_code }}</span></p>
                        </div>
                        <x-status-badge :status="$booking->status" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 text-xs">
                        <div class="rounded-2xl bg-slate-50 p-3 border border-slate-100">
                            <p class="text-slate-400 font-medium">Tanggal Keberangkatan</p>
                            <p class="font-bold text-slate-900 mt-0.5 text-sm">{{ $booking->availability->departure_date->format('d M Y') }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3 border border-slate-100">
                            <p class="text-slate-400 font-medium">Jumlah Peserta</p>
                            <p class="font-bold text-slate-900 mt-0.5 text-sm">
                                {{ $booking->adult_count }} Dewasa
                                @if($booking->child_count > 0), {{ $booking->child_count }} Anak @endif
                                @if($booking->infant_count > 0), {{ $booking->infant_count }} Bayi @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Payment Options Card --}}
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Pilih Nominal Pembayaran</h3>
                    
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <label class="relative flex flex-col justify-between rounded-2xl border p-4 cursor-pointer transition-all duration-200" 
                               :class="paymentType === 'deposit' ? 'border-emerald-500 bg-emerald-50/30 ring-1 ring-emerald-500/20' : 'border-slate-200/80 hover:border-slate-300'">
                            <input type="radio" x-model="paymentType" value="deposit" class="sr-only">
                            <div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-bold text-slate-700">Bayar Uang Muka (DP)</p>
                                    <span class="h-2 w-2 rounded-full" :class="paymentType === 'deposit' ? 'bg-emerald-500' : 'bg-slate-200'"></span>
                                </div>
                                <p class="mt-2 text-xl font-extrabold text-emerald-600">Rp {{ number_format($depositAmount, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-3 leading-relaxed">Amankan kuota Anda sekarang, pelunasan dapat dilakukan sebelum keberangkatan.</p>
                        </label>

                        <label class="relative flex flex-col justify-between rounded-2xl border p-4 cursor-pointer transition-all duration-200" 
                               :class="paymentType === 'full' ? 'border-emerald-500 bg-emerald-50/30 ring-1 ring-emerald-500/20' : 'border-slate-200/80 hover:border-slate-300'">
                            <input type="radio" x-model="paymentType" value="full" class="sr-only">
                            <div>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-bold text-slate-700">Bayar Lunas</p>
                                    <span class="h-2 w-2 rounded-full" :class="paymentType === 'full' ? 'bg-emerald-500' : 'bg-slate-200'"></span>
                                </div>
                                <p class="mt-2 text-xl font-extrabold text-emerald-600">Rp {{ number_format($balanceDue, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-3 leading-relaxed">Pembayaran penuh, transaksi selesai tanpa perlu tagihan tambahan.</p>
                        </label>
                    </div>

                    {{-- Payment Method Selection --}}
                    <h3 class="mt-8 text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Metode Pembayaran</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach ([
                            ['id'=>'bank_transfer', 'label'=>'Transfer Bank', 'icon'=>'M3 10h18M7 15h1m4 0h1m4 0h1M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['id'=>'e_wallet', 'label'=>'Dompet Digital', 'icon'=>'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                            ['id'=>'credit_card', 'label'=>'Kartu Kredit', 'icon'=>'M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z']
                        ] as $m)
                            <label class="flex flex-col items-center justify-center rounded-2xl border p-3.5 text-center cursor-pointer transition-all duration-200" 
                                   :class="method === '{{ $m['id'] }}' ? 'border-emerald-500 bg-emerald-50/30 text-emerald-700 ring-1 ring-emerald-500/20' : 'border-slate-200/80 text-slate-600 hover:border-slate-300'">
                                <input type="radio" x-model="method" value="{{ $m['id'] }}" class="sr-only">
                                <svg class="h-5 w-5 mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}"/>
                                </svg>
                                <span class="text-xs font-bold">{{ $m['label'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Notice Alert --}}
                    <div class="mt-6 rounded-2xl bg-amber-50/80 border border-amber-200/60 p-4 text-xs text-amber-900 leading-relaxed flex items-start gap-3">
                        <svg class="h-5 w-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-bold">Informasi Pembayaran Simulasi</p>
                            <p class="mt-0.5 text-amber-800/90">Gerbang pembayaran otomatis akan segera hadir. Konfirmasi pembayaran pada halaman ini akan diverifikasi secara manual oleh tim Admin kami.</p>
                        </div>
                    </div>

                    {{-- Action Form --}}
                    <form method="POST" action="{{ route('booking.pay', $booking) }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="payment_type" x-bind:value="paymentType">
                        <input type="hidden" name="method" x-bind:value="method">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 py-3.5 text-sm font-extrabold text-white shadow-md hover:bg-amber-600 transition">
                            <span>Bayar &amp; Konfirmasi Sekarang</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Breakdown Sidebar Component --}}
            <div class="lg:col-span-2">
                <x-price-breakdown :booking="$booking" />
            </div>
        </div>
    </div>
</div>
</x-app-layout>