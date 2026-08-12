<x-app-layout :title="$blogPost->title" :meta-description="$blogPost->excerpt">
    <article>
        <div class="relative h-[340px] overflow-hidden bg-ink">
            <img src="{{ $blogPost->featured_image ? asset('storage/'.$blogPost->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&q=70' }}"
                 class="absolute inset-0 h-full w-full object-cover opacity-60" alt="{{ $blogPost->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/40 to-transparent"></div>
            <div class="container-page relative z-10 flex h-full flex-col justify-end pb-8 max-w-3xl mx-auto">
                @if ($blogPost->category)
                    <span class="badge bg-primary text-white w-fit">{{ $blogPost->category->name }}</span>
                @endif
                <h1 class="mt-3 text-3xl font-bold text-white">{{ $blogPost->title }}</h1>
                <p class="mt-2 text-sm text-slate-300">By {{ $blogPost->author->name ?? 'Editorial Team' }} &middot; {{ optional($blogPost->published_at)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="container-page py-12">
            <div class="prose prose-slate max-w-3xl mx-auto text-muted leading-relaxed whitespace-pre-line">
                {!! nl2br(e($blogPost->content)) !!}
            </div>
        </div>
    </article>

    @if ($relatedPosts->isNotEmpty())
    <section class="bg-white border-t border-slate-100 py-12">
        <div class="container-page">
            <h2 class="section-title !text-2xl">Related Articles</h2>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $post)
                    <x-blog-card :post="$post" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-app-layout>
