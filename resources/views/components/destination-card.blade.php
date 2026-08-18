@props(['destination'])

<a href="{{ route('destinations.show', $destination->slug) }}" 
   class="group relative flex h-80 w-full items-end overflow-hidden rounded-3xl bg-slate-900 shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/10 focus:outline-none">
    
    {{-- Destination Image --}}
    <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80' }}"
         alt="{{ $destination->name }}" 
         loading="lazy"
         class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
    
    {{-- Dark Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent transition-opacity duration-300 group-hover:from-slate-950/95"></div>

    {{-- Content Container --}}
    <div class="relative z-10 w-full p-6 text-white transition-transform duration-300 group-hover:-translate-y-1">
        
        {{-- Country Tag --}}
        <div class="flex items-center gap-1.5 mb-1.5">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-300">
                {{ $destination->country }}
            </span>
        </div>

        {{-- Destination Name --}}
        <h3 class="text-2xl font-extrabold tracking-tight text-white group-hover:text-emerald-200 transition-colors duration-200">
            {{ $destination->name }}
        </h3>

        {{-- Additional Info / Tour Count Badge --}}
        <div class="mt-3 flex items-center justify-between pt-3 border-t border-white/10">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 backdrop-blur-md px-3 py-1 text-xs font-medium text-slate-200 border border-white/10">
                <svg class="h-3.5 w-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                {{ $destination->tour_packages_count ?? $destination->tourPackages->count() }} Paket Wisata
            </span>

            {{-- Arrow Icon --}}
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white transition duration-300 group-hover:bg-emerald-500 group-hover:text-slate-950">
                <svg class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </span>
        </div>
    </div>
</a>