<x-app-layout title="Jelajahi Indonesia">
    {{-- Hero Section --}}
    <section class="relative min-h-[85vh] flex items-center justify-center bg-slate-950 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80" alt="Indonesia Travel"
             class="absolute inset-0 h-full w-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/30 to-slate-950/60"></div>

        <div class="container-page relative z-10 py-24 lg:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900/80 px-3.5 py-1.5 text-xs font-medium text-emerald-400 border border-slate-800 mb-6 backdrop-blur-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    <span>Pilihan Perjalanan Terpercaya Sejak 2014</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-bold tracking-tight text-white leading-tight">
                    Jelajahi Keindahan <span class="text-emerald-400">Indonesia</span> Bersama Kami
                </h1>
                
                <p class="mt-6 text-base sm:text-lg text-slate-300 font-normal leading-relaxed max-w-2xl">
                    Dari pesona Komodo hingga keajaiban Raja Ampat — nikmati kemudahan liburan tanpa ribet dengan layanan travel profesional.
                </p>

                {{-- Form pencarian dibuat lebih solid & riil --}}
                <div class="mt-8 bg-white p-2 rounded-2xl shadow-xl max-w-2xl border border-slate-100">
                    <form action="{{ route('tours.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                        <div class="flex-1 flex items-center px-3 gap-3">
                            <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" placeholder="Cari destinasi, misalnya &quot;Bali&quot; atau &quot;Raja Ampat&quot;..."
                                   class="w-full bg-transparent text-slate-900 placeholder-slate-400 text-sm font-medium focus:outline-none py-2.5">
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-3 rounded-xl transition duration-150 text-sm shrink-0">
                            Cari Paket
                        </button>
                    </form>
                </div>

                {{-- Statistik Minimalis --}}
                <div class="mt-12 flex flex-wrap items-center gap-8 border-t border-slate-800/80 pt-8">
                    <div>
                        <p class="text-2xl font-bold text-white tracking-tight">10.000+</p>
                        <p class="text-xs text-slate-400 mt-0.5">Wisatawan Terlayani</p>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-800"></div>
                    <div>
                        <p class="text-2xl font-bold text-white tracking-tight">150+</p>
                        <p class="text-xs text-slate-400 mt-0.5">Destinasi Pilihan</p>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-800"></div>
                    <div>
                        <p class="text-2xl font-bold text-white tracking-tight">4.9 / 5</p>
                        <p class="text-xs text-slate-400 mt-0.5">Rating Kepuasan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinasi Pilihan --}}
    <section class="container-page py-20">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Eksplorasi Surga Tersembunyi</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Destinasi Pilihan</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition group">
                Lihat semua destinasi 
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($featuredDestinations as $destination)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition duration-200">
                    <x-destination-card :destination="$destination" />
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-500 text-sm">Belum ada destinasi yang ditampilkan saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Popular Paket Wisata --}}
    <section class="bg-slate-50 py-20 border-y border-slate-200/80">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Favorit Para Pelancong</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Paket Wisata Populer</h2>
                </div>
                <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition group">
                    Lihat semua paket wisata 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularPaketWisata as $tour)
                    <div class="transition duration-200 hover:-translate-y-1">
                        <x-tour-card :tour="$tour" />
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-500 text-sm">Paket wisata akan segera hadir.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="container-page py-20">
        <div class="max-w-xl mb-14">
            <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Keunggulan Kami</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Perjalanan Nyaman Tanpa Khawatir</h2>
            <p class="text-slate-600 mt-2 text-sm leading-relaxed">Kami mengurus segala kebutuhan logistik Anda agar setiap momen liburan terasa berkesan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jadwal Terpercaya', 'desc' => 'Itinerary disusun presisi dan dikonfirmasi langsung dengan vendor terverifikasi.'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1m0-8a9 9 0 100 18 9 9 0 000-18z', 'title' => 'Harga Transparan', 'desc' => 'Rincian biaya jelas tanpa ada tambahan biaya tersembunyi saat di lapangan.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Pembayaran Aman', 'desc' => 'Sistem transaksi resmi dengan fleksibilitas DP maupun pelunasan langsung.'],
                ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => 'Dukungan 24/7', 'desc' => 'Tim penanggung jawab lokal siap membantu sebelum hingga sesudah perjalanan.'],
            ] as $item)
                <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-emerald-500/30 transition duration-200">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-5 text-base font-bold text-slate-900">{{ $item['title'] }}</h3>
                    <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- How It Works --}}
    <section class="bg-slate-900 text-white py-20">
        <div class="container-page">
            <div class="max-w-xl mb-14">
                <span class="text-xs font-semibold tracking-wider text-emerald-400 uppercase">Alur Pemesanan</span>
                <h2 class="text-2xl sm:text-3xl font-bold mt-1">Cara Pesan Dalam 4 Langkah</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['step' => '01', 'title' => 'Pilih Paket', 'desc' => 'Cari dan tentukan paket wisata yang sesuai kebutuhan Anda.'],
                    ['step' => '02', 'title' => 'Pilih Tanggal', 'desc' => 'Tentukan jadwal keberangkatan yang tersedia secara real-time.'],
                    ['step' => '03', 'title' => 'Pembayaran', 'desc' => 'Selesaikan pembayaran DP atau pelunasan melalui payment gateway.'],
                    ['step' => '04', 'title' => 'Siap Berangkat', 'desc' => 'Nikmati liburan Anda, seluruh tiket & itinerari dikirim instan.'],
                ] as $s)
                    <div class="p-6 rounded-2xl bg-slate-800/50 border border-slate-800">
                        <span class="text-xs font-bold text-emerald-400 bg-emerald-950 px-2.5 py-1 rounded-md border border-emerald-800/50 inline-block">{{ $s['step'] }}</span>
                        <h3 class="mt-4 text-base font-bold text-white">{{ $s['title'] }}</h3>
                        <p class="mt-2 text-xs text-slate-400 leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
    <section class="container-page py-20">
        <div class="max-w-xl mb-12">
            <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Ulasan Pelanggan</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Pengalaman Cerita Mereka</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($testimonials as $review)
                <div class="rounded-2xl p-6 bg-white border border-slate-200/80 shadow-sm">
                    <x-review-card :review="$review" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Galeri Preview --}}
    @if ($galleryPreview->isNotEmpty())
    <section class="bg-slate-50 py-20 border-y border-slate-200/80">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Dokumentasi</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Galeri Perjalanan</h2>
                </div>
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition group">
                    Lihat semua foto
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ($galleryPreview->take(8) as $image)
                    <div class="group aspect-square overflow-hidden rounded-xl bg-slate-200 relative">
                        <img src="{{ $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=60' }}"
                             alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Latest Blog --}}
    @if ($latestPosts->isNotEmpty())
    <section class="container-page py-20">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-semibold tracking-wider text-emerald-700 uppercase">Artikel & Tips</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Jurnal Perjalanan</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition group">
                Baca Blog
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach ($latestPosts as $post)
                <div class="transition duration-200 hover:-translate-y-1">
                    <x-blog-card :post="$post" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Call To Action (CTA) Banner --}}
    <section class="container-page pb-20">
        <div class="rounded-3xl bg-emerald-900 px-6 py-14 sm:px-12 sm:py-16 text-center shadow-lg border border-emerald-800">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-4xl font-bold text-white tracking-tight">Siap Untuk Petualangan Selanjutnya?</h2>
                <p class="mt-3 text-emerald-100 text-sm sm:text-base font-normal leading-relaxed">Buat akun gratis sekarang untuk menyimpan destinasi favorit dan kelola seluruh rencana perjalanan Anda dalam satu tempat.</p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('tours.index') }}" class="w-full sm:w-auto bg-white hover:bg-slate-100 text-slate-900 font-semibold px-6 py-3 rounded-xl transition duration-150 text-sm">
                        Cari Paket Wisata
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-emerald-800 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl border border-emerald-700 transition duration-150 text-sm">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>