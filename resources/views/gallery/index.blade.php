<x-app-layout title="Galeri Foto">
<div x-data="{ lightboxOpen: false, activeImage: null, activeCaption: '' }">
    
    {{-- Header & Filter Section --}}
    <section class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16">
        <div class="container-page">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Momen Indah Perjalanan</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-2 tracking-tight">Galeri Foto</h1>
            <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl font-light">
                Kumpulan dokumentasi keindahan alam dan momen berharga peserta tour bersama Nusantara Journeys.
            </p>

            {{-- Filter Destination Pills --}}
            <form action="{{ route('gallery.index') }}" method="GET" class="mt-8 flex flex-wrap items-center gap-2">
                <a href="{{ route('gallery.index') }}" 
                   class="rounded-full px-4 py-2 text-xs font-semibold transition-all duration-200 {{ ! request('destination') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-500 hover:text-emerald-600' }}">
                    Semua Foto
                </a>
                @foreach ($destinations as $d)
                    <a href="{{ route('gallery.index', ['destination' => $d->id]) }}"
                       class="rounded-full px-4 py-2 text-xs font-semibold transition-all duration-200 {{ request('destination') == $d->id ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:border-emerald-500 hover:text-emerald-600' }}">
                        {{ $d->name }}
                    </a>
                @endforeach
            </form>
        </div>
    </section>

    {{-- Gallery Grid Section --}}
    <section class="container-page py-12 sm:py-16">
        @if ($images->isEmpty())
            <div class="p-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <x-empty-state title="Belum Ada Foto" description="Belum ada dokumentasi foto untuk kategori ini. Kembali lagi nanti!" />
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($images as $image)
                    @php 
                        $url = $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80'; 
                        $caption = $image->caption ?? $image->title;
                    @endphp
                    <button type="button" 
                            @click="lightboxOpen = true; activeImage = '{{ $url }}'; activeCaption = @js($caption)"
                            class="group relative aspect-square w-full overflow-hidden rounded-2xl bg-slate-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 focus:outline-none">
                        
                        {{-- Photo Image --}}
                        <img src="{{ $url }}" alt="{{ $image->title }}" loading="lazy" 
                             class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-110">
                        
                        {{-- Hover Overlay with Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4 text-left">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-md mb-2">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                </svg>
                            </span>
                            @if ($caption)
                                <p class="text-xs font-medium text-white line-clamp-2 leading-snug">{{ $caption }}</p>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $images->links() }}
            </div>
        @endif
    </section>

    {{-- Modern Lightbox Modal --}}
    <div x-show="lightboxOpen" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="lightboxOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4 sm:p-8" 
         @click.self="lightboxOpen = false">
        
        {{-- Close Button --}}
        <button @click="lightboxOpen = false" 
                class="absolute top-5 right-5 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition focus:outline-none" 
                aria-label="Tutup">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Lightbox Container --}}
        <div class="max-w-5xl w-full"
             x-show="lightboxOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="overflow-hidden rounded-2xl bg-black/40 border border-white/10 p-2 shadow-2xl">
                <img :src="activeImage" class="max-h-[80vh] w-full rounded-xl object-contain mx-auto" alt="Preview Gambar">
            </div>

            <div x-show="activeCaption" class="mt-4 text-center">
                <p class="text-sm sm:text-base font-medium text-slate-200 bg-slate-900/60 inline-block px-4 py-2 rounded-full border border-white/10 backdrop-blur-sm" x-text="activeCaption"></p>
            </div>
        </div>
    </div>

</div>
</x-app-layout>