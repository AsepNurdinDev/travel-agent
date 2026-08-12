@props(['post'])
<a href="{{ route('blog.show', $post->slug) }}" class="card group flex flex-col overflow-hidden transition hover:shadow-lg hover:-translate-y-0.5">
    <div class="aspect-[16/10] w-full overflow-hidden bg-slate-100">
        <img src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=600&q=60' }}"
             alt="{{ $post->title }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
    </div>
    <div class="flex flex-1 flex-col p-4">
        @if ($post->category)
            <p class="text-xs font-semibold uppercase tracking-wide text-primary">{{ $post->category->name }}</p>
        @endif
        <h3 class="mt-1 line-clamp-2 text-base font-bold text-ink group-hover:text-primary">{{ $post->title }}</h3>
        <p class="mt-2 line-clamp-2 text-sm text-muted">{{ $post->excerpt }}</p>
        <p class="mt-auto pt-4 text-xs text-muted">{{ optional($post->published_at)->format('d M Y') }}</p>
    </div>
</a>
