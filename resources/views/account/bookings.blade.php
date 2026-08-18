<x-app-layout title="Pesanan Saya">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Page Header --}}
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Pesanan Saya</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola dan pantau status seluruh riwayat pemesanan paket wisata Anda.</p>
        </div>

        {{-- Horizontal Tab Filter --}}
        <div class="flex items-center gap-2 overflow-x-auto border-b border-slate-100 pb-3 no-scrollbar">
            @php
                $tabs = [
                    'all' => 'Semua',
                    'upcoming' => 'Akan Datang',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp

            @foreach ($tabs as $key => $label)
                <a href="{{ route('account.bookings', ['tab' => $key]) }}"
                   class="shrink-0 inline-flex items-center justify-center rounded-xl px-4 py-2 text-xs font-bold transition-all duration-200 {{ $tab === $key ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100/80 text-slate-600 hover:bg-slate-200/60 hover:text-slate-900' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Bookings List / Empty State --}}
        @if ($bookings->isEmpty())
            <x-empty-state 
                title="Tidak Ada Pesanan" 
                description="Belum ada riwayat pesanan untuk kategori ini. Siap untuk menjelajahi tempat baru?">
                <x-slot:action>
                    <a href="{{ route('tours.index') }}" 
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                        <span>Jelajahi Paket Wisata</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </x-slot:action>
            </x-empty-state>
        @else
            <div class="space-y-3.5">
                @foreach ($bookings as $booking)
                    <x-booking-summary :booking="$booking" />
                @endforeach
            </div>

            {{-- Pagination Container --}}
            <div class="pt-6">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>
</x-app-layout>