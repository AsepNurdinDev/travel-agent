<x-app-layout title="Blog Perjalanan">
    {{-- Header Section --}}
    <section class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16">
        <div class="container-page">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Jurnal & Panduan Wisata</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-2 tracking-tight">Blog Perjalanan</h1>
            <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl font-light">
                Temukan inspirasi, tips liburan, dan panduan lengkap dari para penjelajah untuk petualangan Anda berikutnya.
            </p>
        </div>
    </section>

    {{-- Featured Post --}}
    @if ($featuredPost)
    <section class="container-page py-10">
        <a href="{{ route('blog.show', $featuredPost->slug) }}" 
           class="group relative grid grid-cols-1 lg:grid-cols-12 overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-xl shadow-slate-100 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10">
            
            {{-- Image Container --}}
            <div class="lg:col-span-7 aspect-[16/10] lg:aspect-auto overflow-hidden bg-slate-100 relative">
                <img src="{{ $featuredPost->featured_image ? asset('storage/'.$featuredPost->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800&q=80' }}"
                     class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105" 
                     alt="{{ $featuredPost->title }}">
                <div class="absolute inset-0 bg-slate-950/10 group-hover:bg-transparent transition duration-300"></div>
            </div>

            {{-- Content Container --}}
            <div class="lg:col-span-5 p-8 lg:p-12 flex flex-col justify-between bg-white">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                            Pilihan Utama
                        </span>
                        @if ($featuredPost->category)
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                {{ $featuredPost->category->name }}
                            </span>
                        @endif
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 group-hover:text-emerald-600 transition duration-200 leading-snug">
                        {{ $featuredPost->title }}
                    </h2>
                    
                    <p class="mt-4 text-slate-600 line-clamp-3 text-sm leading-relaxed font-light">
                        {{ $featuredPost->excerpt }}
                    </p>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ optional($featuredPost->published_at)->format('d M Y') }}</span>
                    </div>
                    <span class="inline-flex items-center gap-1 font-bold text-emerald-600 group-hover:translate-x-1 transition duration-200">
                        Baca Selengkapnya
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </div>
            </div>
        </a>
    </section>
    @endif

    {{-- Main Blog Content & Sidebar --}}
    <section class="container-page pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
            
            {{-- Articles List Grid --}}
            <div class="lg:col-span-3">
                @if ($posts->isEmpty())
                    <div class="p-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                        <x-empty-state title="Belum Ada Artikel" description="Kembali lagi nanti untuk melihat cerita dan panduan perjalanan terbaru." />
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        @foreach ($posts as $post)
                            <div class="transition-transform duration-300 hover:-translate-y-1">
                                <x-blog-card :post="$post" />
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-8">
                
                {{-- Search Widget --}}
                <div class="rounded-2xl bg-white p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-sm tracking-wide uppercase">Cari Artikel</h3>
                    <form action="{{ route('blog.index') }}" method="GET" class="mt-4">
                        <div class="relative rounded-xl shadow-sm">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Kata kunci..." 
                                   class="w-full rounded-xl border border-slate-200 pl-4 pr-10 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                            <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-emerald-600 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Categories Widget --}}
                <div class="rounded-2xl bg-white p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-sm tracking-wide uppercase">Kategori</h3>
                    <ul class="mt-4 space-y-1">
                        <li>
                            <a href="{{ route('blog.index') }}" 
                               class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-medium transition-colors duration-150 {{ ! request('category') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <span>Semua Artikel</span>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs text-slate-600 font-semibold">{{ $posts->total() }}</span>
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            @php $isCatActive = request('category') == $category->id; @endphp
                            <li>
                                <a href="{{ route('blog.index', ['category' => $category->id]) }}"
                                   class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-medium transition-colors duration-150 {{ $isCatActive ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="rounded-full {{ $isCatActive ? 'bg-emerald-200/60 text-emerald-800' : 'bg-slate-100 text-slate-500' }} px-2.5 py-0.5 text-xs font-semibold">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </aside>
        </div>
    </section>
</x-app-layout>