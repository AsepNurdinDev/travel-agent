<x-app-layout title="Daftar Tagihan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        {{-- Page Header --}}
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Tagihan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola dan pantau seluruh status pembayaran serta riwayat invoice Anda.</p>
        </div>

        {{-- Invoices List / Empty State --}}
        @if ($invoices->isEmpty())
            <x-empty-state 
                title="Belum Ada Tagihan" 
                description="Tagihan akan dibuat secara otomatis saat Anda melakukan pemesanan paket wisata.">
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
                @foreach ($invoices as $invoice)
                    <x-invoice-card :invoice="$invoice" />
                @endforeach
            </div>

            {{-- Pagination Container --}}
            <div class="pt-6">
                {{ $invoices->links() }}
            </div>
        @endif

    </div>
</x-app-layout>