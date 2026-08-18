<x-app-layout :title="$destination->name" :meta-description="$destination->description">
    {{-- Hero Header Section --}}
    <section class="relative h-[400px] sm:h-[480px] overflow-hidden bg-slate-950">
        <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80' }}"
             alt="{{ $destination->name }}" 
             class="absolute inset-0 h-full w-full object-cover opacity-60 transform scale-105 transition-transform duration-1000">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
        
        <div class="container-page relative z-10 flex h-full flex-col justify-end pb-10 sm:pb-14">
            <div class="flex items-center gap-2">
                <span class="inline-block rounded-full bg-emerald-500/20 px-3.5 py-1 text-xs font-bold uppercase tracking-widest text-emerald-300 backdrop-blur-md border border-emerald-500/30">
                    {{ $destination->country }}
                </span>
            </div>
            <h1 class="mt-3 text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                {{ $destination->name }}
            </h1>
            <p class="mt-2 flex items-center gap-1.5 text-sm sm:text-base text-slate-200 font-light">
                <svg class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0"/>
                </svg>
                {{ $destination->city }}, {{ $destination->country }}
            </p>
        </div>
    </section>

    {{-- Content Details & Sidebar Section --}}
    <section class="container-page py-12 sm:py-16 grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- Left Column: Description & Gallery --}}
        <div class="lg:col-span-2 space-y-10">
            <div>
                <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Informasi Destinasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Tentang {{ $destination->name }}</h2>
                <div class="mt-4 leading-relaxed text-slate-600 font-light text-base sm:text-lg whitespace-pre-line space-y-4">
                    {{ $destination->description }}
                </div>
            </div>

            {{-- Gallery Grid --}}
            @if ($destination->galleries && $destination->galleries->isNotEmpty())
                <div class="pt-6 border-t border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Galeri Dokumentasi</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                        @foreach ($destination->galleries as $image)
                            @php 
                                $galleryUrl = $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=600&q=80'; 
                            @endphp
                            <div class="group relative aspect-square overflow-hidden rounded-2xl bg-slate-100 shadow-sm">
                                <img src="{{ $galleryUrl }}"
                                     alt="{{ $image->title ?? $destination->name }}" 
                                     loading="lazy" 
                                     class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-110">
                                <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column: Quick Facts Card --}}
        <div>
            <div class="sticky top-6 rounded-3xl bg-white p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-100">
                <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900">Fakta Singkat</h3>
                        <p class="text-xs text-slate-500">Ringkasan lokasi destinasi</p>
                    </div>
                </div>

                <dl class="mt-5 space-y-4 text-sm">
                    <div class="flex items-center justify-between py-1">
                        <dt class="text-slate-500 font-medium">Negara</dt>
                        <dd class="font-semibold text-slate-900">{{ $destination->country }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-1 border-t border-slate-100">
                        <dt class="text-slate-500 font-medium">Kota / Wilayah</dt>
                        <dd class="font-semibold text-slate-900">{{ $destination->city }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-1 border-t border-slate-100">
                        <dt class="text-slate-500 font-medium">Paket Wisata Tersedia</dt>
                        <dd class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700">
                            {{ $tours->total() }} Paket
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    {{-- Tours Section --}}
    <section class="bg-slate-50 border-t border-slate-200/60 py-12 sm:py-16">
        <div class="container-page">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Pilihan Perjalanan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">
                        Paket Wisata di {{ $destination->name }}
                    </h2>
                </div>
            </div>

            @if ($tours->isEmpty())
                <div class="p-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <x-empty-state 
                        title="Belum Ada Paket Wisata" 
                        description="Belum ada paket tur yang tersedia untuk destinasi ini. Silakan periksa kembali nanti!" />
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($tours as $tour)
                        <x-tour-card :tour="$tour" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $tours->links() }}
                </div>
            @endif
        </div>
    </section>
</x-app-layout>