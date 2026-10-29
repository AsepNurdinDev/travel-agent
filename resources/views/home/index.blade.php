<x-app-layout title="Jelajahi Indonesia">
    {{-- Hero Section (tema travel: langit, matahari, awan, pesawat, ombak) --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-ocean-600 via-ocean-500 to-sky-200 text-white">
        <span class="tv-bob absolute right-[10%] top-20 h-24 w-24 rounded-full bg-sun-300 shadow-[0_0_80px_30px_rgba(255,178,122,.55)]"></span>
        <span class="tv-drift absolute left-0 top-28 text-6xl opacity-80" aria-hidden="true">☁️</span>
        <span class="tv-drift absolute left-0 top-56 text-5xl opacity-60" style="animation-duration:95s;animation-delay:-35s" aria-hidden="true">☁️</span>
        <span class="tv-drift absolute left-0 top-16 text-7xl opacity-50" style="animation-duration:120s;animation-delay:-70s" aria-hidden="true">☁️</span>

        {{-- Pesawat dengan jejak putus-putus --}}
        <div class="tv-fly absolute left-0 top-40 z-10 hidden items-center sm:flex" aria-hidden="true">
            <div class="h-0.5 w-48 border-t-2 border-dashed border-white/70"></div>
            <svg viewBox="0 0 64 64" class="h-12 w-12 drop-shadow-xl"><path fill="#fff" d="M60 32 40 24 28 6h-6l6 18H12l-6-8H2l4 16-4 16h4l6-8h16l-6 18h6l12-18 20-8c3-1 3-3 0-4Z"/></svg>
        </div>

        <div class="container-page relative z-10 pb-28 pt-16 text-center sm:pt-24 lg:pb-36">
            <span data-reveal class="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1.5 text-xs font-bold backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-sun-300 tv-glow"></span>
                Pilihan Travel Terpercaya Indonesia
            </span>

            <h1 data-reveal class="font-display mx-auto mt-5 max-w-4xl text-4xl font-extrabold leading-[1.08] sm:text-6xl lg:text-7xl">
                Temukan Keajaiban <span class="text-sun-300">Nusantara</span> Tanpa Ribet
            </h1>
            <p data-reveal class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
                Dari lanskap eksotis Komodo hingga beningnya air Raja Ampat. Kami merancang setiap detail perjalanan agar Anda bisa fokus menikmati setiap momen.
            </p>

            {{-- Form pencarian (tetap ke tours.index?search=) --}}
            <form data-reveal action="{{ route('tours.index') }}" method="GET"
                  class="mx-auto mt-9 flex max-w-2xl flex-col gap-2 rounded-[2rem] bg-white p-2.5 text-left shadow-2xl sm:flex-row">
                <label class="flex flex-1 items-center gap-3 rounded-2xl px-4 hover:bg-ocean-50">
                    <span class="text-lg">📍</span>
                    <input type="text" name="search" placeholder="Mau liburan ke mana? (misal: Bali, Labuan Bajo...)"
                           class="w-full bg-transparent py-3 text-sm font-semibold text-navy placeholder-slate-400 focus:outline-none">
                </label>
                <button type="submit" class="btn btn-accent shrink-0 px-8">Cari Paket ✈</button>
            </form>

            <div data-reveal class="mt-4 flex flex-wrap items-center justify-center gap-x-3 gap-y-1 text-xs text-white/80">
                <span class="font-semibold">Populer:</span>
                <a href="{{ route('tours.index', ['search' => 'Bali']) }}" class="transition hover:text-sun-300">#Bali</a>
                <a href="{{ route('tours.index', ['search' => 'Labuan Bajo']) }}" class="transition hover:text-sun-300">#LabuanBajo</a>
                <a href="{{ route('tours.index', ['search' => 'Raja Ampat']) }}" class="transition hover:text-sun-300">#RajaAmpat</a>
                <a href="{{ route('tours.index', ['search' => 'Bromo']) }}" class="transition hover:text-sun-300">#Bromo</a>
            </div>

            <dl data-reveal class="mx-auto mt-12 grid max-w-xl grid-cols-3 gap-4">
                <div><dd class="text-2xl font-extrabold sm:text-3xl"><span data-count="10000">0</span>+</dd><dt class="mt-0.5 text-xs text-white/75">Wisatawan Terlayani</dt></div>
                <div><dd class="text-2xl font-extrabold sm:text-3xl"><span data-count="150">0</span>+</dd><dt class="mt-0.5 text-xs text-white/75">Destinasi Terverifikasi</dt></div>
                <div><dd class="text-2xl font-extrabold sm:text-3xl">4.9<span class="text-base">/5</span></dd><dt class="mt-0.5 text-xs text-white/75">Ulasan Kepuasan</dt></div>
            </dl>
        </div>

        {{-- Elemen melayang + ombak --}}
        <span class="tv-bob absolute bottom-24 left-[7%] z-10 hidden text-5xl sm:block" aria-hidden="true">🎈</span>
        <span class="tv-bob absolute bottom-20 left-[45%] z-10 hidden text-4xl sm:block" style="animation-delay:-3s" aria-hidden="true">⛵</span>
        <span class="tv-pin absolute bottom-24 right-[9%] z-10 hidden text-4xl sm:block" aria-hidden="true">📍</span>
        <div class="absolute inset-x-0 bottom-0">
            <x-wave color="#ffffff" class="opacity-60" slow />
            <x-wave color="#F8FAFC" class="-mt-[78px]" />
        </div>
    </section>

    {{-- Destinasi Pilihan --}}
    <section class="container-page py-16 sm:py-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="inline-block text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2.5 py-1 rounded-md mb-2">
                    Eksplorasi Nusantara
                </span>
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Destinasi Pilihan Terbaik</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                Lihat semua destinasi 
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($featuredDestinations as $destination)
                <div data-reveal class="group relative overflow-hidden rounded-3xl">
                    <x-destination-card :destination="$destination" />
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-ocean-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-500 text-sm">Belum ada destinasi yang ditampilkan saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Popular Paket Wisata --}}
    <section class="bg-ocean-50 py-16 sm:py-24 border-y border-slate-200/70">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="inline-block text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-100/60 px-2.5 py-1 rounded-md mb-2">
                        Favorit Pelancong
                    </span>
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Paket Wisata Populer</h2>
                </div>
                <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                    Lihat semua paket 
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularPaketWisata as $tour)
                    <div data-reveal>
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
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
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
                    <div data-reveal data-tilt class="p-6 rounded-3xl bg-white border border-ocean-100 shadow-sm hover:shadow-xl hover:shadow-ocean-900/10">
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
    <section class="bg-navy text-white py-16 sm:py-24 relative overflow-hidden">
        <span class="tv-spin absolute -right-10 -top-10 text-[12rem] opacity-10" aria-hidden="true">🧭</span>
        <div class="container-page relative z-10">
            <div class="max-w-xl mb-12">
                <span class="text-xs font-bold tracking-wider text-sun-300 uppercase bg-white/10 px-3 py-1 rounded-full">
                    Proses Pemesanan
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold mt-3">Pesan Mudah Dalam 4 Langkah</h2>
            </div>

            <div class="relative">
                <svg class="absolute left-[6%] right-[6%] top-[2.9rem] hidden h-3 w-[88%] lg:block" viewBox="0 0 400 10" preserveAspectRatio="none" aria-hidden="true"><path class="tv-dash" d="M0 5H400" stroke="#FF8A3D" stroke-width="2" fill="none"/></svg>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                @foreach ([
                    ['step' => '01', 'title' => 'Pilih Paket Wisata', 'desc' => 'Temukan paket perjalanan yang paling sesuai dengan durasi & budget Anda.'],
                    ['step' => '02', 'title' => 'Tentukan Tanggal', 'desc' => 'Pilih jadwal keberangkatan yang tersedia pada kalendar interaktif.'],
                    ['step' => '03', 'title' => 'Pembayaran Aman', 'desc' => 'Lakukan konfirmasi pemesanan dengan opsi DP atau pembayaran penuh.'],
                    ['step' => '04', 'title' => 'Siap Berlibur', 'desc' => 'Voucher dan itinerari lengkap akan dikirimkan secara instan.'],
                ] as $index => $s)
                    <div data-reveal class="p-6 rounded-3xl bg-white/5 border border-white/10 hover:border-sun-400/60 hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-black text-navy bg-sun-400 px-3 py-1 rounded-full inline-block">
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
            <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Apa Kata Mereka?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($testimonials as $review)
                <div data-reveal class="rounded-3xl p-6 bg-white border border-ocean-100 shadow-sm hover:shadow-md transition">
                    <x-review-card :review="$review" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Galeri Preview (Bento Layout) --}}
    @if ($galleryPreview->isNotEmpty())
    <section class="bg-ocean-50 py-16 sm:py-24 border-y border-slate-200/70">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-700 uppercase bg-emerald-100/60 px-2.5 py-1 rounded-md">
                        Momen Perjalanan
                    </span>
                    <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Dokumentasi Wisatawan</h2>
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
                <h2 class="font-display text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Jurnal & Tips Liburan</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition group">
                Baca semua artikel
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach ($latestPosts as $post)
                <div data-reveal class="transition duration-300 hover:-translate-y-1">
                    <x-blog-card :post="$post" />
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Call To Action (CTA) Banner --}}
    <section class="container-page pb-16 sm:pb-24">
        <div class="rounded-[2.5rem] bg-gradient-to-br from-sun-500 to-sun-300 px-6 py-14 sm:px-14 sm:py-16 text-center shadow-xl relative overflow-hidden">
            <span class="tv-spin absolute -right-14 -top-14 text-[12rem] opacity-20" aria-hidden="true">🧭</span>
            <div class="max-w-2xl mx-auto relative z-10">
                <h2 class="font-display text-2xl sm:text-5xl font-extrabold text-navy tracking-tight">Siap Untuk Petualangan Selanjutnya?</h2>
                <p class="mt-3 text-navy/80 text-sm sm:text-base font-semibold leading-relaxed">Daftar sekarang untuk menyimpan destinasi impian Anda dan dapatkan penawaran paket wisata eksklusif.</p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('tours.index') }}" class="w-full sm:w-auto bg-navy hover:bg-ocean-700 text-white font-bold px-7 py-3 rounded-full transition duration-150 text-sm shadow-md active:scale-95">
                        Jelajahi Paket Wisata
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white hover:bg-ocean-50 text-navy font-bold px-7 py-3 rounded-full transition duration-150 text-sm active:scale-95">
                        Buat Akun Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>