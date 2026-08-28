<x-app-layout title="Jelajahi Indonesia">
    {{-- Hero Section --}}
    <section class="relative min-h-[85vh] flex items-center bg-slate-950 overflow-hidden">
        {{-- Background Image dengan Soft Overlay Natural --}}
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80" alt="Indonesia Travel"
             class="absolute inset-0 h-full w-full object-cover opacity-35 scale-105 transition duration-1000 ease-out">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/70"></div>

        <div class="container-page relative z-10 py-20 lg:py-28">
            <div class="max-w-3xl">
                {{-- Trust Badge --}}
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3.5 py-1.5 text-xs font-semibold text-emerald-400 border border-emerald-500/20 mb-6 backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Pilihan Travel Terpercaya Indonesia</span>
                </div>

                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-[1.15]">
                    Temukan Keajaiban <span class="text-emerald-400">Nusantara</span> Tanpa Ribet
                </h1>
                
                <p class="mt-5 text-base sm:text-lg text-slate-300 font-normal leading-relaxed max-w-2xl">
                    Dari lanskap eksotis Komodo hingga beningnya air Raja Ampat. Kami merancang setiap detail perjalanan agar Anda bisa fokus menikmati setiap momen.
                </p>

                {{-- Form Pencarian Terintegrasi & Natural --}}
                <div class="mt-8 bg-white/95 backdrop-blur-md p-2 rounded-2xl shadow-2xl max-w-2xl border border-white/20">
                    <form action="{{ route('tours.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                        <div class="flex-1 flex items-center px-3.5 gap-3">
                            <svg class="h-5 w-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" placeholder="Mau liburan ke mana? (misal: Bali, Labuan Bajo...)"
                                   class="w-full bg-transparent text-slate-900 placeholder-slate-400 text-sm font-medium focus:outline-none py-3">
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-7 py-3 rounded-xl transition duration-150 text-sm shrink-0 shadow-md active:scale-95">
                            Cari Paket
                        </button>
                    </form>
                </div>

                {{-- Popular Search Tags --}}
                <div class="mt-3 flex items-center gap-2 text-xs text-slate-400 px-1">
                    <span class="font-medium text-slate-300">Popular:</span>
                    <a href="{{ route('tours.index', ['search' => 'Bali']) }}" class="hover:text-emerald-400 transition">#Bali</a>
                    <a href="{{ route('tours.index', ['search' => 'Labuan Bajo']) }}" class="hover:text-emerald-400 transition">#LabuanBajo</a>
                    <a href="{{ route('tours.index', ['search' => 'Raja Ampat']) }}" class="hover:text-emerald-400 transition">#RajaAmpat</a>
                    <a href="{{ route('tours.index', ['search' => 'Bromo']) }}" class="hover:text-emerald-400 transition">#Bromo</a>
                </div>

                {{-- Statistik Bersih & Realistis --}}
                <div class="mt-12 flex flex-wrap items-center gap-8 border-t border-slate-800/80 pt-8">
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white tracking-tight">10.000+</p>
                        <p class="text-xs text-slate-400 mt-0.5">Wisatawan Terlayani</p>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-800"></div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white tracking-tight">150+</p>
                        <p class="text-xs text-slate-400 mt-0.5">Destinasi Terverifikasi</p>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-slate-800"></div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white tracking-tight">4.9 / 5.0</p>
                        <p class="text-xs text-slate-400 mt-0.5">Ulasan Kepuasan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinasi Pilihan --}}
    <section class="container-page py-16 sm:py-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="inline-block text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2.5 py-1 rounded-md mb-2">
                    Eksplorasi Nusantara
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Destinasi Pilihan Terbaik</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                Lihat semua destinasi 
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($featuredDestinations as $destination)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300">
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
    <section class="bg-slate-50 py-16 sm:py-24 border-y border-slate-200/70">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="inline-block text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-100/60 px-2.5 py-1 rounded-md mb-2">
                        Favorit Pelancong
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Paket Wisata Populer</h2>
                </div>
                <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                    Lihat semua paket 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularPaketWisata as $tour)
                    <div class="transition duration-300 hover:-translate-y-1">
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

    {{-- Keunggulan (Layout Asimetris yang Terlihat Dibuat Desainer) --}}
    <section class="container-page py-16 sm:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-5 space-y-4">
                <span class="text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2.5 py-1 rounded-md">
                    Mengapa Memilih Kami
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    Perjalanan Nyaman, Fokus Nikmati Liburan
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Kami menangani seluruh kebutuhan logistik, transportasi, dan rute perjalanan agar Anda dan keluarga bisa berlibur tanpa hambatan.
                </p>
                <div class="pt-2">
                    <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                        Pelajari standar layanan kami
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ([
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jadwal Terencana', 'desc' => 'Itinerary disusun realistis bersama pemandu lokal terverifikasi di setiap area.'],
                    ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1m0-8a9 9 0 100 18 9 9 0 000-18z', 'title' => 'Harga Tanpa Biaya Tersembunyi', 'desc' => 'Rincian biaya jujur dan transparan sejak awal pemesanan dilakukan.'],
                    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Transaksi Resmi & Safe', 'desc' => 'Dukungan berbagai kanal pembayaran tepercaya dengan opsi DP atau Pelunasan.'],
                    ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => 'Dukungan Lapangan 24/7', 'desc' => 'Tim penanggung jawab lokal siap membantu kebutuhan perjalanan Anda setiap saat.'],
                ] as $item)
                    <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-emerald-300 transition duration-200">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                        </div>
                        <h3 class="mt-4 text-base font-bold text-slate-900">{{ $item['title'] }}</h3>
                        <p class="mt-1.5 text-xs text-slate-500 leading-relaxed font-normal">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works (Alur Berantai) --}}
    <section class="bg-slate-950 text-white py-16 sm:py-24 relative overflow-hidden">
        <div class="container-page relative z-10">
            <div class="max-w-xl mb-12">
                <span class="text-xs font-bold tracking-wider text-emerald-400 uppercase bg-emerald-950/80 border border-emerald-800/50 px-2.5 py-1 rounded-md">
                    Proses Pemesanan
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold mt-3">Pesan Mudah Dalam 4 Langkah</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                @foreach ([
                    ['step' => '01', 'title' => 'Pilih Paket Wisata', 'desc' => 'Temukan paket perjalanan yang paling sesuai dengan durasi & budget Anda.'],
                    ['step' => '02', 'title' => 'Tentukan Tanggal', 'desc' => 'Pilih jadwal keberangkatan yang tersedia pada kalendar interaktif.'],
                    ['step' => '03', 'title' => 'Pembayaran Aman', 'desc' => 'Lakukan konfirmasi pemesanan dengan opsi DP atau pembayaran penuh.'],
                    ['step' => '04', 'title' => 'Siap Berlibur', 'desc' => 'Voucher dan itinerari lengkap akan dikirimkan secara instan.'],
                ] as $index => $s)
                    <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800/80 hover:border-slate-700 transition duration-200 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-black text-emerald-400 bg-emerald-950 px-3 py-1 rounded-md border border-emerald-800/60 inline-block">
                                {{ $s['step'] }}
                            </span>
                            <h3 class="mt-5 text-lg font-bold text-white">{{ $s['title'] }}</h3>
                            <p class="mt-2 text-xs text-slate-400 leading-relaxed font-normal">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
    <section class="container-page py-16 sm:py-24">
        <div class="max-w-xl mb-12">
            <span class="text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2.5 py-1 rounded-md">
                Cerita Wisatawan
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Apa Kata Mereka?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($testimonials as $review)
                <div class="rounded-2xl p-6 bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
                    <x-review-card :review="$review" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Galeri Preview (Bento Layout) --}}
    @if ($galleryPreview->isNotEmpty())
    <section class="bg-slate-50 py-16 sm:py-24 border-y border-slate-200/70">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-100/60 px-2.5 py-1 rounded-md">
                        Momen Perjalanan
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Dokumentasi Wisatawan</h2>
                </div>
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                    Lihat galeri foto
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                @foreach ($galleryPreview->take(8) as $image)
                    <div class="group aspect-square overflow-hidden rounded-2xl bg-slate-200 relative shadow-sm">
                        <img src="{{ $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=60' }}"
                             alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Latest Blog --}}
    @if ($latestPosts->isNotEmpty())
    <section class="container-page py-16 sm:py-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2.5 py-1 rounded-md">
                    Inspirasi Perjalanan
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Jurnal & Tips Liburan</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                Baca semua artikel
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach ($latestPosts as $post)
                <div class="transition duration-300 hover:-translate-y-1">
                    <x-blog-card :post="$post" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Call To Action (CTA) Banner --}}
    <section class="container-page pb-16 sm:pb-24">
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 px-6 py-12 sm:px-14 sm:py-16 text-center shadow-xl border border-slate-800 relative overflow-hidden">
            <div class="max-w-2xl mx-auto relative z-10">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Siap Untuk Petualangan Selanjutnya?</h2>
                <p class="mt-3 text-slate-300 text-xs sm:text-base font-normal leading-relaxed">Daftar sekarang untuk menyimpan destinasi impian Anda dan dapatkan penawaran paket wisata eksklusif.</p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('tours.index') }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-7 py-3 rounded-xl transition duration-150 text-sm shadow-md active:scale-95">
                        Jelajahi Paket Wisata
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-7 py-3 rounded-xl border border-slate-700 transition duration-150 text-sm active:scale-95">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>