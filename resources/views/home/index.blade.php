<x-app-layout title="Jelajahi Indonesia">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-ink">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=70" alt=""
             class="absolute inset-0 h-full w-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/70 to-ink/30"></div>

        <div class="container-page relative z-10 py-24 sm:py-32">
            <p class="section-eyebrow text-primary-200">Pilihan perjalanan terbaik sejak 2014</p>
            <h1 class="mt-3 max-w-2xl text-4xl sm:text-5xl font-bold leading-tight text-white">
                Jelajahi Indonesia, satu perjalanan berkesan setiap saat.
            </h1>
            <p class="mt-4 max-w-xl text-lg text-slate-200">
                Dari Komodo hingga Raja Ampat — kami siapkan semuanya, Anda tinggal menikmati perjalanan.
            </p>

            {{-- Paket Wisata Search --}}
            <form action="{{ route('tours.index') }}" method="GET"
                  class="mt-8 flex flex-col gap-3 rounded-2xl bg-white p-3 shadow-xl sm:flex-row sm:items-center max-w-2xl">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari wisata, misalnya &quot;Bali&quot; atau &quot;Raja Ampat&quot;..."
                           class="input !border-0 !ring-0 !shadow-none focus:!ring-0 text-ink">
                </div>
                <button type="submit" class="btn-primary shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/></svg>
                    Cari Paket Wisata
                </button>
            </form>
        </div>
    </section>

    {{-- Destinasi Pilihan --}}
    <section class="container-page py-16 sm:py-20">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="section-eyebrow">Mau ke mana selanjutnya?</p>
                <h2 class="section-title">Destinasi Pilihan</h2>
            </div>
            <a href="{{ route('destinations.index') }}" class="btn-outline shrink-0">Lihat semua destinasi</a>
        </div>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($featuredDestinations as $destination)
                <x-destination-card :destination="$destination" />
            @empty
                <p class="text-muted">Destinasi will appear here once published.</p>
            @endforelse
        </div>
    </section>

    {{-- Popular Paket Wisata --}}
    <section class="bg-white py-16 sm:py-20 border-y border-slate-100">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="section-eyebrow">Pilihan favorit pelanggan</p>
                    <h2 class="section-title">Paket Wisata Populer</h2>
                </div>
                <a href="{{ route('tours.index') }}" class="btn-outline shrink-0">Lihat semua paket wisata</a>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($popularPaketWisata as $tour)
                    <x-tour-card :tour="$tour" />
                @empty
                    <p class="text-muted">Paket Wisata packages will appear here once published.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Why Choose Us --}}
    <section class="container-page py-16 sm:py-20">
        <div class="text-center max-w-2xl mx-auto">
            <p class="section-eyebrow">Kenapa memilih kami?</p>
            <h2 class="section-title">Perjalanan yang kami siapkan dengan baik</h2>
        </div>

        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Jadwal perjalanan terpercaya', 'desc' => 'Every itinerary is checked against real hotel, vehicle and guide availability.'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1m0-8a9 9 0 100 18 9 9 0 000-18z', 'title' => 'Harga transparan', 'desc' => 'Clear adult / child / infant rates, no hidden fees on add-ons or promos.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Pembayaran aman', 'desc' => 'Pay a deposit or in full, with every payment tracked against your invoice.'],
                ['icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'title' => '24/7 Support', 'desc' => 'A local team on call before, during, and after your trip.'],
            ] as $item)
                <div class="card p-6">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-50 text-primary">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                    </div>
                    <h3 class="mt-4 font-bold text-ink">{{ $item['title'] }}</h3>
                    <p class="mt-1.5 text-sm text-muted leading-relaxed">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- How It Works --}}
    <section class="bg-primary-50/60 py-16 sm:py-20">
        <div class="container-page">
            <div class="text-center max-w-2xl mx-auto">
                <p class="section-eyebrow">Simple by design</p>
                <h2 class="section-title">How booking works</h2>
            </div>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['step' => '1', 'title' => 'Pick a tour', 'desc' => 'Browse destinations and compare packages side by side.'],
                    ['step' => '2', 'title' => 'Pilih tanggal perjalanan', 'desc' => 'Pilih tanggal keberangkatan yang masih tersedia dan lihat harga saat ini.'],
                    ['step' => '3', 'title' => 'Book & pay', 'desc' => 'Reserve with a deposit or pay in full — your choice.'],
                    ['step' => '4', 'title' => 'Pack your bags', 'desc' => 'We handle the logistics; you handle the excitement.'],
                ] as $s)
                    <div class="text-center">
                        <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary text-lg font-bold text-white">{{ $s['step'] }}</span>
                        <h3 class="mt-4 font-bold text-ink">{{ $s['title'] }}</h3>
                        <p class="mt-1.5 text-sm text-muted">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
    <section class="container-page py-16 sm:py-20">
        <div class="text-center max-w-2xl mx-auto">
            <p class="section-eyebrow">Traveler stories</p>
            <h2 class="section-title">What our guests say</h2>
        </div>

        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($testimonials as $review)
                <x-review-card :review="$review" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- Galeri Preview --}}
    @if ($galleryPreview->isNotEmpty())
    <section class="bg-white border-y border-slate-100 py-16 sm:py-20">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="section-eyebrow">Moments captured</p>
                    <h2 class="section-title">From the Galeri</h2>
                </div>
                <a href="{{ route('gallery.index') }}" class="btn-outline shrink-0">Lihat semua galeri</a>
            </div>
            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ($galleryPreview->take(8) as $image)
                    <div class="aspect-square overflow-hidden rounded-xl bg-slate-100">
                        <img src="{{ $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=60' }}"
                             alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover hover:scale-105 transition duration-300">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Latest Blog --}}
    @if ($latestPosts->isNotEmpty())
    <section class="container-page py-16 sm:py-20">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="section-eyebrow">From the journal</p>
                <h2 class="section-title">Latest from the Blog</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="btn-outline shrink-0">Read the blog</a>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach ($latestPosts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="container-page pb-16 sm:pb-20">
        <div class="rounded-3xl bg-primary px-8 py-14 text-center sm:px-16">
            <h2 class="text-3xl font-bold text-white">Ready for your next adventure?</h2>
            <p class="mt-3 text-primary-100 max-w-xl mx-auto">Create a free account to save favorites, book in minutes, and track every trip in one place.</p>
            <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('tours.index') }}" class="btn-accent">Browse Paket Wisata</a>
                <a href="{{ route('register') }}" class="btn bg-white text-primary hover:bg-primary-50">Buat Akun Gratis</a>
            </div>
        </div>
    </section>
</x-app-layout>