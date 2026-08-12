<x-app-layout :title="$destination->name" :meta-description="$destination->description">
    <section class="relative h-[380px] overflow-hidden bg-ink">
        <img src="{{ $destination->image ? asset('storage/'.$destination->image) : 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=70' }}"
             alt="{{ $destination->name }}" class="absolute inset-0 h-full w-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/40 to-transparent"></div>
        <div class="container-page relative z-10 flex h-full flex-col justify-end pb-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-primary-200">{{ $destination->country }}</p>
            <h1 class="mt-2 text-4xl font-bold text-white">{{ $destination->name }}</h1>
            <p class="mt-1 text-slate-200">{{ $destination->city }}</p>
        </div>
    </section>

    <section class="container-page py-12 grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-ink">About {{ $destination->name }}</h2>
            <p class="mt-3 leading-relaxed text-muted whitespace-pre-line">{{ $destination->description }}</p>

            @if ($destination->galleries->isNotEmpty())
                <h3 class="mt-10 text-lg font-bold text-ink">Gallery</h3>
                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach ($destination->galleries as $image)
                        <div class="aspect-square overflow-hidden rounded-xl bg-slate-100">
                            <img src="{{ $image->image ? asset('storage/'.$image->image) : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=400&q=60' }}"
                                 alt="{{ $image->title }}" loading="lazy" class="h-full w-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card p-6 h-fit">
            <h3 class="font-bold text-ink">Quick Facts</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-muted">Country</dt><dd class="font-medium text-ink">{{ $destination->country }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">City</dt><dd class="font-medium text-ink">{{ $destination->city }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted">Tours available</dt><dd class="font-medium text-ink">{{ $tours->total() }}</dd></div>
            </dl>
        </div>
    </section>

    <section class="bg-white border-t border-slate-100 py-12">
        <div class="container-page">
            <h2 class="section-title !text-2xl">Tours in {{ $destination->name }}</h2>
            @if ($tours->isEmpty())
                <div class="mt-6"><x-empty-state title="No tours yet" description="Check back soon — new tours are added regularly." /></div>
            @else
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($tours as $tour)
                        <x-tour-card :tour="$tour" />
                    @endforeach
                </div>
                <div class="mt-10">{{ $tours->links() }}</div>
            @endif
        </div>
    </section>
</x-app-layout>
