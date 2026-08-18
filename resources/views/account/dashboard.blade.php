<x-app-layout title="Ringkasan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        {{-- Welcome Hero Banner --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800 p-6 sm:p-8 text-white shadow-md">
            {{-- Decorative Background Circle --}}
            <div class="absolute -right-10 -bottom-10 h-48 w-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-20 -top-10 h-32 w-32 rounded-full bg-emerald-400/20 blur-xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold backdrop-blur-md border border-white/20">
                    <span class="h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    Dashboard Pelanggan
                </span>
                <h1 class="mt-3 text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Selamat datang kembali, {{ Str::of(auth()->user()->name)->before(' ') }}! 👋
                </h1>
                <p class="mt-2 text-sm text-emerald-100/90 leading-relaxed">
                    Lihat ringkasan status perjalanan, riwayat pemesanan, dan aktivitas liburan Anda di sini.
                </p>
            </div>
        </div>

        {{-- Stat Cards Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            @php
                $statsConfig = [
                    [
                        'label' => 'Total Pesanan',
                        'value' => $stats['total'],
                        'bg' => 'bg-emerald-50 text-emerald-600',
                        'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'
                    ],
                    [
                        'label' => 'Akan Datang',
                        'value' => $stats['upcoming'],
                        'bg' => 'bg-blue-50 text-blue-600',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'label' => 'Perjalanan Selesai',
                        'value' => $stats['completed'],
                        'bg' => 'bg-teal-50 text-teal-600',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'label' => 'Pending Pembayaran',
                        'value' => $stats['pending_payment'],
                        'bg' => 'bg-amber-50 text-amber-600',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1'
                    ],
                ];
            @endphp

            @foreach ($statsConfig as $card)
                <div class="group relative rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $card['bg'] }} transition-transform duration-200 group-hover:scale-110">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $card['value'] }}</p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">{{ $card['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pending Payment Notice --}}
        @if ($stats['pending_payment'] > 0)
            <div class="rounded-2xl bg-amber-50/80 border border-amber-200/70 p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="rounded-xl bg-amber-100 p-2 text-amber-700 shrink-0 mt-0.5 sm:mt-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900">Tagihan Belum Lunas</h4>
                        <p class="text-xs text-amber-800/90 mt-0.5">
                            Anda memiliki <span class="font-bold text-amber-900">{{ $stats['pending_payment'] }} pesanan</span> yang membutuhkan penyelesaian pembayaran.
                        </p>
                    </div>
                </div>
                <a href="{{ route('account.bookings') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-amber-600 transition shrink-0">
                    <span>Bayar Tagihan</span>
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif

        {{-- Upcoming Trip Section --}}
        @if ($upcomingBooking)
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Perjalanan Berikutnya
                    </h2>
                </div>
                <x-booking-summary :booking="$upcomingBooking" />
            </div>
        @endif

        {{-- Recent Bookings Section --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-base font-bold text-slate-900">Pesanan Terbaru</h2>
                <a href="{{ route('account.bookings') }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                    <span>Lihat Semua</span>
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if ($recentBookings->isEmpty())
                <x-empty-state title="Belum Ada Pesanan" description="Siap untuk petualangan berikutnya? Jelajahi berbagai paket wisata menarik kami.">
                    <x-slot:action>
                        <a href="{{ route('tours.index') }}" 
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                            Cari Paket Wisata
                        </a>
                    </x-slot:action>
                </x-empty-state>
            @else
                <div class="space-y-3">
                    @foreach ($recentBookings as $booking)
                        <x-booking-summary :booking="$booking" />
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>