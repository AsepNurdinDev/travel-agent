@props(['booking'])

<a href="{{ route('account.bookings.show', $booking) }}" 
   class="group relative flex flex-col sm:flex-row gap-5 rounded-3xl border border-slate-100 bg-white p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-slate-200">
    
    {{-- Cover Image --}}
    <div class="relative h-40 sm:h-auto sm:w-44 shrink-0 overflow-hidden rounded-2xl bg-slate-100">
        <img src="{{ $booking->tourPackage->cover_image ? asset('storage/'.$booking->tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=400&q=80' }}"
             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" 
             alt="{{ $booking->tourPackage->name }}">
        
        @if($booking->tourPackage->destination)
            <span class="absolute top-2.5 left-2.5 rounded-full bg-slate-900/60 backdrop-blur-md px-2.5 py-1 text-[10px] font-bold text-white uppercase tracking-wider">
                {{ $booking->tourPackage->destination->name }}
            </span>
        @endif
    </div>

    {{-- Details & Metadata --}}
    <div class="flex flex-1 flex-col justify-between min-w-0">
        <div>
            {{-- Header: Code & Status --}}
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <span class="inline-block rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-mono font-bold text-slate-600">
                        {{ $booking->booking_code }}
                    </span>
                    <h3 class="mt-1.5 text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate">
                        {{ $booking->tourPackage->name }}
                    </h3>
                </div>
                <x-status-badge :status="$booking->status" class="shrink-0" />
            </div>

            {{-- Summary Chips --}}
            <div class="mt-3.5 grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                <div class="rounded-xl bg-slate-50 p-2.5 border border-slate-100/80">
                    <p class="text-[11px] text-slate-400 font-medium">Berangkat</p>
                    <p class="font-bold text-slate-800 mt-0.5 truncate">
                        {{ optional($booking->availability)->departure_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-2.5 border border-slate-100/80">
                    <p class="text-[11px] text-slate-400 font-medium">Peserta</p>
                    <p class="font-bold text-slate-800 mt-0.5 truncate">
                        {{ $booking->adult_count + $booking->child_count + $booking->infant_count }} Orang
                    </p>
                </div>

                <div class="col-span-2 sm:col-span-1 rounded-xl bg-slate-50 p-2.5 border border-slate-100/80">
                    <p class="text-[11px] text-slate-400 font-medium">Total Tagihan</p>
                    <p class="font-bold text-slate-900 mt-0.5 truncate">
                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Balance Due Alert --}}
        @if ((float) $booking->balance_due > 0 && $booking->status !== 'cancelled')
            <div class="mt-3.5 flex items-center justify-between rounded-xl bg-amber-50/80 border border-amber-200/60 px-3 py-2 text-xs text-amber-900">
                <div class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">Sisa Pelunasan:</span>
                </div>
                <span class="font-extrabold text-amber-700">Rp {{ number_format($booking->balance_due, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>
</a>