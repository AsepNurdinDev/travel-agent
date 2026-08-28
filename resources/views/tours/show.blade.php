<x-app-layout :title="$tourPackage->name" :meta-description="$tourPackage->meta_description ?? $tourPackage->description">
    @php
        $images = $tourPackage->images->isNotEmpty() ? $tourPackage->images : collect();
        $coverImage = $tourPackage->cover_image ? asset('storage/'.$tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=1200&q=80';
        $galleryImages = collect([$coverImage])->merge($images->map(fn($i) => $i->image ? asset('storage/'.$i->image) : $coverImage))->values();
    @endphp

    <div x-data="{ 
            images: @js($galleryImages),
            activeModal: null,
            openModal(index) { this.activeModal = index; },
            closeModal() { this.activeModal = null; },
            nextImage() { this.activeModal = (this.activeModal + 1) % this.images.length; },
            prevImage() { this.activeModal = (this.activeModal - 1 + this.images.length) % this.images.length; }
         }"
         @keydown.escape.window="closeModal()"
         @keydown.arrow-right.window="if(activeModal !== null) nextImage()"
         @keydown.arrow-left.window="if(activeModal !== null) prevImage()">

        {{-- Interactive Gallery Section --}}
        <section class="bg-slate-950 py-4 sm:py-6">
            <div class="container-page">
                {{-- DESKTOP GRID LAYOUT --}}
                <div class="hidden md:grid grid-cols-4 gap-3 h-[420px]">
                    <div class="col-span-2 lg:col-span-3 relative h-full overflow-hidden rounded-2xl bg-slate-900 group cursor-pointer"
                         @click="openModal(0)">
                        <img :src="images[0]" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" alt="{{ $tourPackage->name }}">
                        <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/10 transition"></div>
                        <span class="absolute bottom-4 left-4 inline-flex items-center gap-1.5 rounded-full bg-slate-950/70 backdrop-blur-md px-3 py-1.5 text-xs font-semibold text-white border border-white/10">
                            <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Klik untuk perbesar
                        </span>
                    </div>

                    <div class="col-span-2 lg:col-span-1 grid grid-cols-2 lg:grid-cols-1 gap-3 h-full">
                        <template x-for="(img, index) in images.slice(1, 3)" :key="index">
                            <div class="relative overflow-hidden rounded-xl bg-slate-900 group cursor-pointer h-full"
                                 @click="openModal(index + 1)">
                                <img :src="img" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" alt="Galeri">
                                <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-transparent transition"></div>
                            </div>
                        </template>

                        <div class="relative overflow-hidden rounded-xl bg-slate-900 group cursor-pointer h-full"
                             @click="openModal(3)">
                            <img :src="images[3] || images[0]" class="h-full w-full object-cover blur-[2px] opacity-60 transition duration-300 group-hover:scale-105" alt="Lihat Semua">
                            <div class="absolute inset-0 bg-slate-950/60 flex flex-col items-center justify-center text-white p-2 text-center">
                                <svg class="h-6 w-6 text-emerald-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-bold" x-text="`+${images.length} Foto`"></span>
                                <span class="text-[10px] text-slate-300">Lihat Galeri</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MOBILE HORIZONTAL SCROLL SLIDER --}}
                <div class="block md:hidden">
                    <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory scrollbar-none pb-2">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="snap-center shrink-0 w-[88vw] h-[240px] relative rounded-2xl overflow-hidden bg-slate-900 border border-white/10"
                                 @click="openModal(index)">
                                <img :src="img" class="h-full w-full object-cover" alt="Galeri Mobile">
                                <div class="absolute bottom-3 right-3 bg-slate-950/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-semibold text-white flex items-center gap-1 border border-white/10">
                                    <svg class="h-3.5 w-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Foto
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- LIGHTBOX FULLSCREEN MODAL --}}
            <div x-show="activeModal !== null" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/95 backdrop-blur-xl p-4"
                 x-cloak>
                <button @click="closeModal()" class="absolute top-5 right-5 z-50 text-slate-400 hover:text-white p-2 rounded-full bg-slate-900/80 border border-white/10 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <button @click="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 z-50 text-white p-3 rounded-full bg-slate-900/80 hover:bg-emerald-600 border border-white/10 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="max-w-4xl max-h-[80vh] w-full flex flex-col items-center justify-center">
                    <template x-for="(img, index) in images" :key="index">
                        <img x-show="activeModal === index" :src="img" class="max-h-[75vh] w-auto max-w-full object-contain rounded-2xl shadow-2xl border border-white/10" alt="Fullscreen View">
                    </template>
                    <div class="mt-4 text-center">
                        <span class="text-xs font-semibold text-slate-400 bg-slate-900/80 px-4 py-1.5 rounded-full border border-white/10">
                            Foto <span x-text="activeModal + 1" class="text-emerald-400"></span> dari <span x-text="images.length"></span>
                        </span>
                    </div>
                </div>
                <button @click="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 z-50 text-white p-3 rounded-full bg-slate-900/80 hover:bg-emerald-600 border border-white/10 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </section>

        {{-- Main Content & Sidebar Layout --}}
        <section class="container-page py-6 sm:py-12 grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-10 pb-28 md:pb-12">
            
            {{-- Main Details Column --}}
            <div class="lg:col-span-2 space-y-8 min-w-0">
                <div>
                    <a href="{{ route('destinations.show', $tourPackage->destination->slug) }}" 
                       class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-600 hover:text-emerald-700 transition bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $tourPackage->destination->name }}
                    </a>
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight leading-snug">
                        {{ $tourPackage->name }}
                    </h1>
                    
                    {{-- Quick Highlights Info Cards --}}
                    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs sm:text-sm text-slate-700">
                        <div class="bg-slate-50 border border-slate-100 p-3 rounded-2xl flex items-center gap-3">
                            <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium uppercase">Durasi Tur</p>
                                <p class="font-bold text-slate-900">{{ $tourPackage->duration_days }}H / {{ $tourPackage->duration_nights }}M</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 p-3 rounded-2xl flex items-center gap-3">
                            <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium uppercase">Kapasitas</p>
                                <p class="font-bold text-slate-900">{{ $tourPackage->min_participants }}–{{ $tourPackage->max_participants }} Orang</p>
                            </div>
                        </div>

                        @if ($tourPackage->reviews_avg_rating)
                            <div class="col-span-2 sm:col-span-1 bg-amber-50/60 border border-amber-100 p-3 rounded-2xl flex items-center gap-3">
                                <div class="p-2 rounded-xl bg-amber-100 text-amber-700 shrink-0">
                                    <svg class="h-5 w-5 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] text-amber-700 font-medium uppercase">Rating Tur</p>
                                    <p class="font-bold text-amber-900">{{ number_format($tourPackage->reviews_avg_rating, 1) }} / 5.0 ({{ $tourPackage->reviews_count }})</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Deskripsi Paket --}}
                <div>
                    <h2 class="text-lg font-bold text-slate-900 mb-2">Tentang Paket Wisata Ini</h2>
                    <p class="text-slate-600 leading-relaxed font-light text-sm sm:text-base whitespace-pre-line">
                        {{ $tourPackage->description }}
                    </p>
                </div>

                {{-- Itinerary --}}
                @if ($tourPackage->itineraries->isNotEmpty())
                    <div class="pt-6 border-t border-slate-100" x-data="{ openDay: 1 }">
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-slate-900">Rencana Perjalanan (Itinerary)</h2>
                            <p class="text-xs sm:text-sm text-slate-500">Ketuk hari untuk melihat rincian kegiatan tur Anda.</p>
                        </div>
                        <div class="space-y-3">
                            @foreach ($tourPackage->itineraries as $day)
                                <div class="rounded-2xl border border-slate-200/80 bg-white overflow-hidden shadow-sm transition hover:border-emerald-300">
                                    <button @click="openDay = openDay === {{ $day->day_number }} ? null : {{ $day->day_number }}"
                                            class="flex w-full items-center justify-between px-5 py-4 text-left font-bold text-slate-900 hover:bg-slate-50 transition">
                                        <span class="flex items-center gap-3 text-sm sm:text-base">
                                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-xs text-emerald-800 font-extrabold">
                                                H{{ $day->day_number }}
                                            </span>
                                            Hari {{ $day->day_number }} — {{ $day->title }}
                                        </span>
                                        <svg class="h-5 w-5 text-slate-400 transition-transform duration-300 shrink-0" 
                                             :class="openDay === {{ $day->day_number }} ? 'rotate-180 text-emerald-600' : ''" 
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openDay === {{ $day->day_number }}" x-collapse x-cloak class="px-5 pb-5 pt-1 text-sm text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50">
                                        {{ $day->description }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Inclusions & Exclusions --}}
                <div class="pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    @if ($tourPackage->inclusions->isNotEmpty())
                        <div class="rounded-2xl bg-emerald-50/60 p-5 border border-emerald-100">
                            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-white text-xs">✓</span>
                                Fasilitas Termasuk
                            </h3>
                            <ul class="mt-3 space-y-2.5">
                                @foreach ($tourPackage->inclusions as $item)
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <svg class="h-4 w-4 shrink-0 text-emerald-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ $item->description }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($tourPackage->exclusions->isNotEmpty())
                        <div class="rounded-2xl bg-rose-50/60 p-5 border border-rose-100">
                            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-rose-500 text-white text-xs">✕</span>
                                Tidak Termasuk
                            </h3>
                            <ul class="mt-3 space-y-2.5">
                                @foreach ($tourPackage->exclusions as $item)
                                    <li class="flex items-start gap-2 text-sm text-slate-700">
                                        <svg class="h-4 w-4 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span>{{ $item->description }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Addons --}}
                @if ($tourPackage->addons->isNotEmpty())
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="text-xl font-bold text-slate-900">Layanan Tambahan (Opsional)</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mb-4">Layanan ekstra yang dapat dipilih saat melakukan konfirmasi pesanan.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($tourPackage->addons as $addon)
                                <div class="rounded-2xl border border-slate-200 bg-white p-4 flex items-center justify-between gap-3 shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $addon->name }}</p>
                                        @if ($addon->description)
                                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $addon->description }}</p>
                                        @endif
                                    </div>
                                    <span class="text-xs font-bold text-emerald-700 shrink-0 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg">
                                        +Rp {{ number_format($addon->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Reviews --}}
                <div class="pt-6 border-t border-slate-100">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">
                                Ulasan Wisatawan {{ $tourPackage->reviews_count ? "($tourPackage->reviews_count)" : '' }}
                            </h3>
                            <p class="text-xs text-slate-500">Pengalaman asli dari pelanggan yang pernah mencoba tur ini.</p>
                        </div>
                        @if ($tourPackage->reviews_avg_rating)
                            <x-rating :value="$tourPackage->reviews_avg_rating" size="md" />
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse ($tourPackage->reviews as $review)
                            <x-review-card :review="$review" />
                        @empty
                            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200/60 sm:col-span-2">
                                <p class="text-sm font-medium text-slate-600">Belum ada ulasan untuk paket ini. Jadilah pemesan pertama!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Desktop Booking Sidebar (Hidden on Mobile) --}}
            <div class="hidden lg:block lg:col-span-1" id="booking-section">
                <div class="sticky top-24 rounded-3xl bg-white p-6 border border-slate-200 shadow-xl shadow-slate-100/70 space-y-5">
                    <div class="pb-4 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Harga Per Orang</span>
                        <div class="mt-1 flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-emerald-600">Rp {{ number_format($tourPackage->price_adult, 0, ',', '.') }}</span>
                            <span class="text-xs text-slate-500 font-medium">/ dewasa</span>
                        </div>
                        <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <div>Anak: <span class="font-bold text-slate-800">Rp {{ number_format($tourPackage->price_child, 0, ',', '.') }}</span></div>
                            <div>Bayi: <span class="font-bold text-slate-800">Rp {{ number_format($tourPackage->price_infant, 0, ',', '.') }}</span></div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center justify-between">
                            <span>Jadwal Keberangkatan</span>
                            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Tersedia</span>
                        </h4>

                        <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                            @forelse ($tourPackage->availabilities as $availability)
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200/80 p-3 text-sm transition hover:border-emerald-500 hover:bg-emerald-50/20">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $availability->departure_date->format('d M Y') }}</p>
                                        <p class="text-xs text-emerald-600 font-medium">Sisa {{ $availability->remaining_quota }} kursi</p>
                                    </div>
                                    @auth
                                        <a href="{{ route('booking.create', $availability) }}" 
                                           class="rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-emerald-500/20 hover:bg-emerald-500 transition active:scale-95">
                                            Pesan
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" 
                                           class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                            Masuk
                                        </a>
                                    @endauth
                                </div>
                            @empty
                                <div class="p-4 text-center rounded-2xl bg-slate-50 border border-slate-100">
                                    <p class="text-xs text-slate-500">Belum ada jadwal keberangkatan mendatang yang dibuka.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100 text-center">
                        <p class="text-[11px] text-slate-400">
                            🔒 Pemesanan Aman & Tanpa Biaya Tersembunyi
                        </p>
                    </div>
                </div>
            </div>

            {{-- Mobile Schedule Section (Only visible on Mobile inside content area) --}}
            <div class="block lg:hidden pt-6 border-t border-slate-100" id="mobile-booking-section">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Pilih Tanggal Keberangkatan</h3>
                <p class="text-xs text-slate-500 mb-4">Tentukan jadwal tanggal tur yang sesuai dengan rencana Anda.</p>
                <div class="space-y-2.5">
                    @forelse ($tourPackage->availabilities as $availability)
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200 p-3.5 text-sm bg-slate-50">
                            <div>
                                <p class="font-bold text-slate-900">{{ $availability->departure_date->format('d M Y') }}</p>
                                <p class="text-xs text-emerald-600 font-medium">Tersedia {{ $availability->remaining_quota }} slot</p>
                            </div>
                            @auth
                                <a href="{{ route('booking.create', $availability) }}" 
                                   class="rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-emerald-500/20 active:scale-95">
                                    Pesan Sekarang
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700">
                                    Masuk untuk Pesan
                                </a>
                            @endauth
                        </div>
                    @empty
                        <div class="p-4 text-center rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-xs text-slate-500">Belum ada jadwal keberangkatan mendatang.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </section>

        {{-- MOBILE STICKY BOTTOM BAR (Tampil hanya di Mobile/HP) --}}
        <div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 px-4 py-3 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-tight">Mulai dari</span>
                    <span class="text-lg font-extrabold text-emerald-600">
                        Rp {{ number_format($tourPackage->price_adult, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] text-slate-500 font-normal">/ org</span>
                </div>
                
                <a href="#mobile-booking-section" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-xs font-bold text-white shadow-lg shadow-emerald-600/30 hover:bg-emerald-500 active:scale-95 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Pilih Jadwal
                </a>
            </div>
        </div>

    </div>
</x-app-layout>