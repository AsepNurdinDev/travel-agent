<x-app-layout title="Jelajahi Indonesia">
    {{-- Hero Section --}}
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-slate-950">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80" alt="Indonesia Travel"
             class="absolute inset-0 h-full w-full object-cover opacity-50 scale-105 transition-transform duration-1000 ease-out">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-transparent to-slate-950/40"></div>

        <div class="container-page relative z-10 py-20 lg:py-32">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold text-emerald-300 backdrop-blur-md border border-white/10 mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Pilihan Perjalanan Terbaik Sejak 2014</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Jelajahi Keindahan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Indonesia</span> Bersama Kami
                </h1>
                
                <p class="mt-5 text-lg sm:text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                    Dari pesona Komodo hingga keajaiban Raja Ampat — nikmati kemudahan liburan tanpa ribet dengan layanan travel profesional.
                </p>

                <div class="mt-8 p-2 sm:p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl max-w-2xl">
                    <form action="{{ route('tours.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 bg-white rounded-xl p-2 shadow-inner">
                        <div class="flex-1 flex items-center px-3 gap-3">
                            <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" placeholder="Cari destinasi, misalnya &quot;Bali&quot; atau &quot;Raja Ampat&quot;..."
                                   class="w-full bg-transparent text-slate-800 placeholder-slate-400 text-sm font-medium focus:outline-none py-2">
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-emerald-500/25 transition duration-200 flex items-center justify-center gap-2 text-sm shrink-0">
                            Cari Paket
                        </button>
                    </form>
                </div>

                <div class="mt-10 grid grid-cols-3 gap-4 border-t border-white/10 pt-6 max-w-lg">
                    <div>
                        <p class="text-2xl font-bold text-white">10k+</p>
                        <p class="text-xs text-slate-400">Wisatawan Happy</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">150+</p>
                        <p class="text-xs text-slate-400">Destinasi Pilihan</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">4.9/5</p>
                        <p class="text-xs text-slate-400">Rating Kepuasan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinasi Pilihan --}}
    <section class="container-page py-20">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Eksplorasi Surga Tersembunyi</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Destinasi Pilihan</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition group">
                Lihat semua destinasi 
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($featuredDestinations as $destination)
                <div class="group relative overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300">
                    <x-destination-card :destination="$destination" />
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-500">Belum ada destinasi yang ditampilkan saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Popular Paket Wisata --}}
    <section class="bg-slate-50/80 py-20 border-y border-slate-200/60">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Favorit Para Pelancong</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Paket Wisata Populer</h2>
                </div>
                <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition group">
                    Lihat semua paket wisata 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularPaketWisata as $tour)
                    <div class="transition-transform duration-300 hover:-translate-y-1">
                        <x-tour-card :tour="$tour" />
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-500">Paket wisata akan segera hadir.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="container-page py-20">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Keunggulan Kami</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Perjalanan Nyaman Tanpa Khawatir</h2>
            <p class="text-slate-600 mt-3">Kami mengurus segala kebutuhan logistik Anda agar setiap momen liburan terasa berkesan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jadwal Terpercaya', 'desc' => 'Itinerary disusun secara presisi dan selalu dikonfirmasi dengan hotel serta transportasi terverifikasi.'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1m0-8a9 9 0 100 18 9 9 0 000-18z', 'title' => 'Harga Transparan', 'desc' => 'Rincian biaya jelas tanpa biaya tersembunyi. Promo dan diskon berlaku sesuai ketentuan.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Pembayaran Aman', 'desc' => 'Transaksi aman melalui sistem pembayaran resmi dengan opsi DP atau pelunasan instan.'],
                ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => 'Dukungan 24/7', 'desc' => 'Tim lokal kami siap membantu Anda kapan saja, sebelum, selama, hingga sesudah perjalanan.'],
            ] as $item)
                <div class="p-8 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-bold text-slate-900">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- How It Works --}}
    <section class="bg-emerald-950 text-white py-20 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container-page relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase">Sangat Mudah</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold mt-1">Cara Pesan Dalam 4 Langkah</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([
                    ['step' => '01', 'title' => 'Pilih Paket', 'desc' => 'Cari dan pilih paket wisata impian sesuai keinginan Anda.'],
                    ['step' => '02', 'title' => 'Pilih Tanggal', 'desc' => 'Tentukan jadwal keberangkatan yang tersedia secara realtime.'],
                    ['step' => '03', 'title' => 'Bayar Mudah', 'desc' => 'Selesaikan pembayaran DP atau pelunasan dengan aman.'],
                    ['step' => '04', 'title' => 'Siap Berangkat', 'desc' => 'Nikmati liburan seru, semua kebutuhan telah kami siapkan!'],
                ] as $s)
                    <div class="relative p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                        <span class="text-3xl font-black text-emerald-400/40 tracking-wider">{{ $s['step'] }}</span>
                        <h3 class="mt-3 text-lg font-bold text-white">{{ $s['title'] }}</h3>
                        <p class="mt-2 text-sm text-slate-300 leading-relaxed">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
    <section class="container-page py-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Ulasan Pelanggan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Pengalaman Cerita Mereka</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($testimonials as $review)
                <div class="rounded-2xl p-6 bg-white border border-slate-100 shadow-sm hover:shadow-md transition">
                    <x-review-card :review="$review" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Galeri Preview --}}
    @if ($galleryPreview->isNotEmpty())
    <section class="bg-slate-50 py-20 border-y border-slate-200/60">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Momen Indah</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Galeri Perjalanan</h2>
                </div>
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition group">
                    Lihat semua foto
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ($galleryPreview->take(8) as $image)
                    <div class="group aspect-square overflow-hidden rounded-2xl bg-slate-200 relative">
                        <img src="{{ $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=60' }}"
                             alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover group-hover:scale-110 transition duration-500 ease-out">
                        <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
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
                <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Artikel & Tips</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1">Jurnal Perjalanan</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition group">
                Baca Blog
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach ($latestPosts as $post)
                <div class="transition-transform duration-300 hover:-translate-y-1">
                    <x-blog-card :post="$post" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Call To Action (CTA) Banner --}}
    <section class="container-page pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-16 sm:px-16 sm:py-20 text-center shadow-2xl">
            <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute -left-10 -top-10 h-64 w-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">Siap Untuk Petualangan Selanjutnya?</h2>
                <p class="mt-4 text-emerald-100 text-base sm:text-lg font-light">Buat akun gratis sekarang untuk menyimpan tempat favorit, booking dalam hitungan menit, dan pantau seluruh rencana liburan Anda.</p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('tours.index') }}" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 text-white font-bold px-8 py-4 rounded-xl shadow-lg transition duration-200">
                        Cari Paket Wisata
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white hover:bg-emerald-50 text-emerald-700 font-bold px-8 py-4 rounded-xl shadow-lg transition duration-200">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>