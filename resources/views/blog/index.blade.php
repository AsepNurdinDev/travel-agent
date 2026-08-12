<x-app-layout title="Travel Blog">
    <section class="border-b border-slate-100 bg-white py-10">
        <div class="container-page">
            <p class="section-eyebrow">Stories & guides</p>
            <h1 class="section-title !text-3xl">Travel Blog</h1>
        </div>
    </section>

    @if ($featuredPost)
    <section class="container-page py-10">
        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="card grid grid-cols-1 lg:grid-cols-2 overflow-hidden group">
            <div class="aspect-[16/10] lg:aspect-auto overflow-hidden bg-slate-100">
                <img src="{{ $featuredPost->featured_image ? asset('storage/'.$featuredPost->featured_image) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800&q=70' }}"
                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105" alt="{{ $featuredPost->title }}">
            </div>
            <div class="p-8 flex flex-col justify-center">
                <span class="badge bg-accent-light text-accent-dark w-fit">Featured</span>
                @if ($featuredPost->category)
                    <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-primary">{{ $featuredPost->category->name }}</p>
                @endif
                <h2 class="mt-2 text-2xl font-bold text-ink group-hover:text-primary">{{ $featuredPost->title }}</h2>
                <p class="mt-3 text-muted line-clamp-3">{{ $featuredPost->excerpt }}</p>
                <p class="mt-4 text-xs text-muted">{{ optional($featuredPost->published_at)->format('d M Y') }}</p>
            </div>
        </a>
    </section>
    @endif

    <section class="container-page pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3">
                @if ($posts->isEmpty())
                    <x-empty-state title="No articles yet" description="Check back soon for travel stories and guides." />
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach ($posts as $post)
                            <x-blog-card :post="$post" />
                        @endforeach
                    </div>
                    <div class="mt-10">{{ $posts->links() }}</div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="card p-5">
                    <h3 class="font-bold text-ink text-sm">Search</h3>
                    <form action="{{ route('blog.index') }}" method="GET" class="mt-3">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="input">
                    </form>
                </div>
                <div class="card p-5">
                    <h3 class="font-bold text-ink text-sm">Categories</h3>
                    <ul class="mt-3 space-y-1">
                        <li><a href="{{ route('blog.index') }}" class="flex justify-between text-sm py-1.5 {{ ! request('category') ? 'text-primary font-medium' : 'text-muted hover:text-ink' }}">All <span>{{ $posts->total() }}</span></a></li>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('blog.index', ['category' => $category->id]) }}"
                                   class="flex justify-between text-sm py-1.5 {{ request('category') == $category->id ? 'text-primary font-medium' : 'text-muted hover:text-ink' }}">
                                    {{ $category->name }} <span>{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </section>
</x-app-layout>
