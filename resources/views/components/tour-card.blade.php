@props(['tour'])
@php
    $avgRating = $tour->reviews_avg_rating ?? null;
    $reviewsCount = $tour->reviews_count ?? null;
@endphp
<a href="{{ route('tours.show', $tour->slug) }}" class="card group flex flex-col overflow-hidden transition hover:shadow-lg hover:-translate-y-0.5">
    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
        <img src="{{ $tour->cover_image ? asset('storage/'.$tour->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=60' }}"
             alt="{{ $tour->name }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @if ($tour->is_featured)
            <span class="badge absolute left-3 top-3 bg-accent text-white">Featured</span>
        @endif
        <span class="badge absolute right-3 top-3 bg-white/95 text-ink">{{ $tour->duration_days }}D{{ $tour->duration_nights }}N</span>
    </div>
    <div class="flex flex-1 flex-col p-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-primary">{{ $tour->destination->name ?? '' }}</p>
        <h3 class="mt-1 line-clamp-2 text-base font-bold text-ink group-hover:text-primary">{{ $tour->name }}</h3>

        @if ($avgRating)
            <div class="mt-2">
                <x-rating :value="$avgRating" :count="$reviewsCount" />
            </div>
        @endif

        <div class="mt-auto pt-4 flex items-end justify-between">
            <div>
                <p class="text-xs text-muted">From</p>
                <p class="text-lg font-bold text-ink">Rp {{ number_format($tour->price_adult, 0, ',', '.') }}</p>
            </div>
            <span class="btn-outline !py-1.5 !px-3 text-xs">Lihat Paket Wisata</span>
        </div>
    </div>
</a>
