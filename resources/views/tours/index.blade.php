<x-app-layout title="Paket Wisata">
    <section class="border-b border-slate-100 bg-white py-10">
        <div class="container-page">
            <p class="section-eyebrow">Find your trip</p>
            <h1 class="section-title !text-3xl">Paket Wisata</h1>

            <form action="{{ route('tours.index') }}" method="GET" class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                <div class="lg:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari paket wisata..." class="input">
                </div>
                <select name="destination" class="input">
                    <option value="">All Destinasi</option>
                    @foreach ($destinations as $d)
                        <option value="{{ $d->id }}" @selected(request('destination') == $d->id)>{{ $d->name }}</option>
                    @endforeach
                </select>
                <select name="duration" class="input">
                    <option value="">Semua Durasi</option>
                    <option value="short" @selected(request('duration') === 'short')>1–3 days</option>
                    <option value="medium" @selected(request('duration') === 'medium')>4–7 days</option>
                    <option value="long" @selected(request('duration') === 'long')>8+ days</option>
                </select>
                <select name="price_max" class="input">
                    <option value="">Semua Harga</option>
                    <option value="2000000" @selected(request('price_max') == 2000000)>Under Rp 2jt</option>
                    <option value="5000000" @selected(request('price_max') == 5000000)>Under Rp 5jt</option>
                    <option value="10000000" @selected(request('price_max') == 10000000)>Under Rp 10jt</option>
                </select>
                <select name="sort" class="input" onchange="this.form.submit()">
                    <option value="">Sort: Featured</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Terendah ke Tertinggi</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Tertinggi ke Terendah</option>
                    <option value="rating" @selected(request('sort') === 'rating')>Highest Rated</option>
                    <option value="duration" @selected(request('sort') === 'duration')>Durasi Terpendek</option>
                </select>
                <button type="submit" class="btn-primary lg:col-span-6 sm:col-span-2 lg:w-fit">Apply Filters</button>
            </form>
        </div>
    </section>

    <section class="container-page py-12">
        <p class="text-sm text-muted mb-6">{{ $tours->total() }} tour{{ $tours->total() === 1 ? '' : 's' }} found</p>

        @if ($tours->isEmpty())
            <x-empty-state title="No tours match your filters" description="Try widening your search or clearing a filter." />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($tours as $tour)
                    <x-tour-card :tour="$tour" />
                @endforeach
            </div>
            <div class="mt-10">{{ $tours->links() }}</div>
        @endif
    </section>
</x-app-layout>
