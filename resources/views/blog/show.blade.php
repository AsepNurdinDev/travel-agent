<x-app-layout :title="$blogPost->title" :meta-description="$blogPost->excerpt">
    <article>
        {{-- Hero Header Section --}}
        <div class="relative min-h-[400px] sm:min-h-[460px] flex items-end overflow-hidden bg-slate-950">
            {{-- Background Image & Overlays --}}
            <img src="{{ $blogPost->featured_image ? asset('storage/'.$blogPost->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=80' }}"
                 class="absolute inset-0 h-full w-full object-cover opacity-50 transform scale-105 transition-transform duration-1000" 
                 alt="{{ $blogPost->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>

            {{-- Title & Meta Container --}}
            <div class="container-page relative z-10 w-full max-w-4xl mx-auto pb-10 pt-20">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-emerald-400 hover:text-emerald-300 transition mb-6">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Blog
                </a>

                @if ($blogPost->category)
                    <div class="mb-4">
                        <span class="inline-block rounded-full bg-emerald-500/20 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-emerald-300 backdrop-blur-md border border-emerald-500/30">
                            {{ $blogPost->category->name }}
                        </span>
                    </div>
                @endif

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    {{ $blogPost->title }}
                </h1>

                {{-- Author & Date Meta --}}
                <div class="mt-6 flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-300">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-emerald-600 flex items-center justify-center font-bold text-white uppercase text-xs">
                            {{ substr($blogPost->author->name ?? 'E', 0, 1) }}
                        </div>
                        <span class="font-medium text-white">{{ $blogPost->author->name ?? 'Tim Redaksi' }}</span>
                    </div>
                    <span class="text-slate-600">&bull;</span>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ optional($blogPost->published_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Article Content --}}
        <div class="bg-white py-12 sm:py-16">
            <div class="container-page max-w-3xl mx-auto">
                {{-- Excerpt / Lead Paragraph --}}
                @if ($blogPost->excerpt)
                    <p class="text-lg sm:text-xl font-medium text-slate-700 leading-relaxed mb-8 border-l-4 border-emerald-500 pl-4 py-1 italic">
                        {{ $blogPost->excerpt }}
                    </p>
                @endif

                {{-- Main Article Text --}}
                <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed font-normal whitespace-pre-line">
                    {!! nl2br(e($blogPost->content)) !!}
                </div>

                {{-- Article Footer Nav --}}
                <div class="mt-12 pt-8 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-700 hover:text-emerald-600 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Lihat Artikel Lainnya
                    </a>
                </div>
            </div>
        </div>
    </article>

    {{-- Related Articles Section --}}
    @if ($relatedPosts->isNotEmpty())
    <section class="bg-slate-50 border-t border-slate-200/60 py-16">
        <div class="container-page">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Rekomendasi</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Artikel Terkait</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition">
                    Semua Artikel
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                @foreach ($relatedPosts as $post)
                    <div class="transition-transform duration-300 hover:-translate-y-1">
                        <x-blog-card :post="$post" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-app-layout>