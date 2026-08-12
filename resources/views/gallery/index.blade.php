<x-app-layout title="Gallery">
<div x-data="{ lightboxOpen: false, activeImage: null, activeCaption: '' }">
    <section class="border-b border-slate-100 bg-white py-10">
        <div class="container-page">
            <p class="section-eyebrow">Moments captured</p>
            <h1 class="section-title !text-3xl">Gallery</h1>

            <form action="{{ route('gallery.index') }}" method="GET" class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('gallery.index') }}" class="btn-outline !py-1.5 !px-3 text-xs {{ ! request('destination') ? '!bg-primary !text-white !border-primary' : '' }}">All</a>
                @foreach ($destinations as $d)
                    <a href="{{ route('gallery.index', ['destination' => $d->id]) }}"
                       class="btn-outline !py-1.5 !px-3 text-xs {{ request('destination') == $d->id ? '!bg-primary !text-white !border-primary' : '' }}">{{ $d->name }}</a>
                @endforeach
            </form>
        </div>
    </section>

    <section class="container-page py-12">
        @if ($images->isEmpty())
            <x-empty-state title="No photos yet" description="Check back soon for photos from our trips." />
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($images as $image)
                    @php $url = $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=600&q=65'; @endphp
                    <button type="button" @click="lightboxOpen = true; activeImage = '{{ $url }}'; activeCaption = @js($image->caption ?? $image->title)"
                            class="aspect-square overflow-hidden rounded-xl bg-slate-100 group">
                        <img src="{{ $url }}" alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                    </button>
                @endforeach
            </div>
            <div class="mt-10">{{ $images->links() }}</div>
        @endif
    </section>

    {{-- Lightbox --}}
    <div x-show="lightboxOpen" x-cloak x-transition.opacity @keydown.escape.window="lightboxOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-ink/90 p-4" @click.self="lightboxOpen = false">
        <button @click="lightboxOpen = false" class="absolute top-5 right-5 text-white/80 hover:text-white" aria-label="Close">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="max-w-4xl w-full">
            <img :src="activeImage" class="max-h-[80vh] w-full rounded-lg object-contain mx-auto" alt="">
            <p class="mt-3 text-center text-sm text-white/80" x-text="activeCaption"></p>
        </div>
    </div>
</div>
</x-app-layout>
