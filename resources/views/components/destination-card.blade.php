@props(['destination'])
<a href="{{ route('destinations.show', $destination->slug) }}" class="group relative flex h-72 items-end overflow-hidden rounded-2xl shadow-card">
    <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=60' }}"
         alt="{{ $destination->name }}" loading="lazy"
         class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-110">
    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/10 to-transparent"></div>
    <div class="relative z-10 p-5 text-white">
        <p class="text-xs font-semibold uppercase tracking-wide text-primary-200">{{ $destination->country }}</p>
        <h3 class="mt-1 text-xl font-bold">{{ $destination->name }}</h3>
        <p class="mt-1 text-sm text-white/80">{{ $destination->tour_packages_count ?? $destination->tourPackages->count() }} tours available</p>
    </div>
</a>
