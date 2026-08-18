<x-app-layout title="Pemesanan Berhasil">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    
    {{-- Header Success Hero --}}
    <div class="mx-auto max-w-2xl text-center">
        <div class="relative mx-auto inline-flex items-center justify-center">
            <span class="animate-ping absolute inline-flex h-16 w-16 rounded-full bg-emerald-400 opacity-20"></span>
            <span class="relative flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
        </div>
        
        <h1 class="mt-6 text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pemesanan Berhasil!</h1>
        <p class="mt-2 text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
            Perjalanan Anda ke <span class="font-bold text-slate-800">{{ $booking->tourPackage->name }}</span> telah dijadwalkan. Rincian konfirmasi telah dikirim ke email Anda.
        </p>
    </div>

    {{-- Booking Detail Card --}}
    <div class="mx-auto mt-10 max-w-2xl rounded-3xl border border-slate-100 bg-white p-6 sm:p-8 shadow-sm">
        
        {{-- Card Header: Booking Code & Status --}}
        <div class="flex items-center justify-between border-b border-slate-100 pb-5">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kode Booking</span>
                <p class="font-mono text-lg font-bold text-slate-900 mt-0.5">{{ $booking->booking_code }}</p>
            </div>
            <x-status-badge :status="$booking->status" />
        </div>

        {{-- Grid Info Trip --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                <p class="text-slate-400 font-medium">Paket Wisata</p>
                <p class="font-bold text-slate-900 text-sm mt-0.5 line-clamp-1">{{ $booking->tourPackage->name }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                <p class="text-slate-400 font-medium">Tanggal Keberangkatan</p>
                <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $booking->availability->departure_date->format('d M Y') }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                <p class="text-slate-400 font-medium">Jumlah Peserta</p>
                <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $booking->adult_count + $booking->child_count + $booking->infant_count }} Orang</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100 flex flex-col justify-between">
                <p class="text-slate-400 font-medium">Status Tagihan</p>
                <div class="mt-1">
                    <x-status-badge :status="$booking->invoice->status ?? 'unpaid'" />
                </div>
            </div>
        </div>

        {{-- Financial Summary Breakdown --}}
        <div class="mt-6 rounded-2xl bg-slate-50/50 p-4 border border-slate-100 space-y-2.5 text-xs">
            <div class="flex justify-between items-center text-slate-500">
                <span>Total Biaya</span>
                <span class="font-bold text-slate-900">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-slate-500">
                <span>Sudah Dibayar</span>
                <span class="font-bold text-emerald-600">Rp {{ number_format($booking->amount_paid, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center border-t border-slate-200/80 pt-2.5 text-sm font-bold text-slate-900">
                <span>Sisa Tagihan</span>
                <span class="text-lg font-extrabold text-slate-900">Rp {{ number_format($booking->balance_due, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mx-auto mt-8 flex max-w-2xl flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('account.bookings.show', $booking) }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat Pesanan
        </a>

        @if ($booking->invoice)
            <a href="{{ route('account.invoices.show', $booking->invoice) }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-xs font-bold text-slate-700 border border-slate-200 hover:bg-slate-50 transition shadow-sm">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat Tagihan
            </a>
        @endif

        <a href="{{ route('home') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            Kembali ke Beranda
        </a>
    </div>

</div>
</x-app-layout>