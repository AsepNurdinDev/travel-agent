<x-app-layout title="Paket Wisata">
    {{-- Header & Filter Section --}}
    <section class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16">
        <div class="container-page">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Pilih Petualangan Anda</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-2 tracking-tight">Paket Wisata</h1>
            <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl font-light">
                Temukan berbagai pilihan paket perjalanan terbaik dengan harga transparan dan itinerary yang terencana matang.
            </p>

            {{-- Filter Form Box --}}
            <div class="mt-8 rounded-3xl bg-white p-5 sm:p-6 border border-slate-100 shadow-xl shadow-slate-100">
                <form action="{{ route('tours.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4">
                    
                    {{-- Search Input --}}
                    <div class="lg:col-span-4 relative">
                        <span class="absolute left-3.5 top-3.5 text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau keyword wisata..." 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-3 pl-11 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                    </div>

                    {{-- Destination Filter --}}
                    <div class="lg:col-span-2">
                        <select name="destination" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-3 px-3 text-sm text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                            <option value="">Semua Destinasi</option>
                            @foreach ($destinations as $d)
                                <option value="{{ $d->id }}" @selected(request('destination') == $d->id)>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Duration Filter --}}
                    <div class="lg:col-span-2">
                        <select name="duration" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-3 px-3 text-sm text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                            <option value="">Semua Durasi</option>
                            <option value="short" @selected(request('duration') === 'short')>1–3 Hari</option>
                            <option value="medium" @selected(request('duration') === 'medium')>4–7 Hari</option>
                            <option value="long" @selected(request('duration') === 'long')>8+ Hari</option>
                        </select>
                    </div>

                    {{-- Price Filter --}}
                    <div class="lg:col-span-2">
                        <select name="price_max" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-3 px-3 text-sm text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200">
                            <option value="">Semua Harga</option>
                            <option value="2000000" @selected(request('price_max') == 2000000)>Di bawah Rp 2 Juta</option>
                            <option value="5000000" @selected(request('price_max') == 5000000)>Di bawah Rp 5 Juta</option>
                            <option value="10000000" @selected(request('price_max') == 10000000)>Di bawah Rp 10 Juta</option>
                        </select>
                    </div>

                    {{-- Sort Filter --}}
                    <div class="lg:col-span-2">
                        <select name="sort" class="w-full rounded-xl border border-slate-200 bg-slate-50/50 py-3 px-3 text-sm text-slate-700 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition duration-200" onchange="this.form.submit()">
                            <option value="">Urutkan: Rekomendasi</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Terendah ke Tertinggi</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Tertinggi ke Terendah</option>
                            <option value="rating" @selected(request('sort') === 'rating')>Rating Tertinggi</option>
                            <option value="duration" @selected(request('sort') === 'duration')>Durasi Terpendek</option>
                        </select>
                    </div>

                    {{-- Actions Buttons --}}
                    <div class="lg:col-span-12 flex flex-wrap items-center justify-between gap-3 pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-emerald-500/20 hover:bg-emerald-500 active:scale-95 transition duration-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Terapkan Filter
                        </button>

                        @if(request()->anyFilled(['search', 'destination', 'duration', 'price_max', 'sort']))
                            <a href="{{ route('tours.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700 underline transition">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Tours Results Grid Section --}}
    <section class="container-page py-12 sm:py-16">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm font-medium text-slate-500">
                Menampilkan <span class="font-bold text-slate-900">{{ $tours->total() }}</span> paket wisata yang sesuai
            </p>
        </div>

        @if ($tours->isEmpty())
            <div class="p-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <x-empty-state 
                    title="Paket Wisata Tidak Ditemukan" 
                    description="Tidak ada paket tur yang cocok dengan filter Anda. Coba kurangi kriteria pencarian atau reset filter." />
                <div class="mt-6">
                    <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white shadow hover:bg-slate-800 transition duration-200">
                        Bersihkan Semua Filter
                    </a>
                </div>
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
    </section>
</x-app-layout>