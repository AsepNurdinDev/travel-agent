@props(['tour'])

@php
    $avgRating = $tour->reviews_avg_rating ?? null;
    $reviewsCount = $tour->reviews_count ?? null;
@endphp

<a href="{{ route('tours.show', $tour->slug) }}" 
   class="group flex flex-col overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-slate-200">
    
    {{-- Image & Badges Container --}}
    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-900">
        <img src="{{ $tour->cover_image ? asset('storage/'.$tour->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800&q=80' }}"
             alt="{{ $tour->name }}" 
             loading="lazy"
             class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
        
        {{-- Soft Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent opacity-60"></div>

        {{-- Top Badges --}}
        <div class="absolute inset-x-3 top-3 flex items-center justify-between gap-2">
            <div>
                @if ($tour->is_featured)
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/90 backdrop-blur-md px-2.5 py-1 text-[11px] font-bold text-white shadow-sm border border-emerald-400/30">
                        <svg class="h-3 w-3 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Unggulan
                    </span>
                @endif
            </div>

            {{-- Duration Badge --}}
            <span class="inline-flex items-center rounded-full bg-slate-950/70 backdrop-blur-md px-3 py-1 text-[11px] font-semibold text-white border border-white/15">
                {{ $tour->duration_days }}H {{ $tour->duration_nights }}M
            </span>
        </div>
    </div>

    {{-- Card Content --}}
    <div class="flex flex-1 flex-col p-5">
        
        {{-- Destination Tag --}}
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">
            {{ $tour->destination->name ?? 'Destinasi' }}
        </p>

        {{-- Tour Title --}}
        <h3 class="mt-1.5 line-clamp-2 text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition duration-200">
            {{ $tour->name }}
        </h3>

        {{-- Rating Section --}}
        @if ($avgRating)
            <div class="mt-2.5 flex items-center gap-1.5">
                <x-rating :value="$avgRating" :count="$reviewsCount" size="sm" />
            </div>
        @else
            <div class="mt-2.5 text-[11px] font-medium text-slate-400">
                Belum ada ulasan
            </div>
        @endif

        {{-- Card Footer: Price & CTA --}}
        <div class="mt-auto pt-5 flex items-end justify-between border-t border-slate-100">
            <div>
                <span class="block text-[11px] font-medium text-slate-400 uppercase tracking-wide">Mulai Dari</span>
                <p class="text-lg font-extrabold text-slate-900">
                    Rp {{ number_format($tour->price_adult, 0, ',', '.') }}
                </p>
            </div>

            <span class="inline-flex items-center gap-1 rounded-xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-700 border border-slate-200/80 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition duration-200">
                Detail
                <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </span>
        </div>
    </div>
</a>