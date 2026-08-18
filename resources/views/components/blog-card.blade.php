@props(['post'])

<a href="{{ route('blog.show', $post->slug) }}" 
   class="group flex flex-col h-full overflow-hidden rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300">
    
    {{-- Image Container --}}
    <div class="aspect-[16/10] w-full overflow-hidden bg-slate-100 relative">
        <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=600&q=80' }}"
             alt="{{ $post->title }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
        
        <div class="absolute inset-0 bg-slate-950/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>

        @if ($post->category)
            <div class="absolute top-3 left-3 z-10">
                <span class="inline-block rounded-full bg-white/90 backdrop-blur-md px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-700 shadow-sm border border-white/50">
                    {{ $post->category->name }}
                </span>
            </div>
        @endif
    </div>

    {{-- Content Container --}}
    <div class="flex flex-1 flex-col p-5 sm:p-6 justify-between">
        <div>
            <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors duration-200 line-clamp-2 leading-snug">
                {{ $post->title }}
            </h3>
            
            <p class="mt-2.5 line-clamp-2 text-xs sm:text-sm text-slate-500 leading-relaxed font-light">
                {{ $post->excerpt }}
            </p>
        </div>

        {{-- Footer Meta & Arrow --}}
        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400">
            <div class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ optional($post->published_at)->format('d M Y') }}</span>
            </div>

            <span class="inline-flex items-center gap-1 font-bold text-emerald-600 group-hover:translate-x-1 transition duration-200">
                Baca
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </div>
    </div>
</a>