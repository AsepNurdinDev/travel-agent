<x-app-layout title="Destinasi Wisata">
    {{-- Header & Search Section --}}
    <section class="border-b border-slate-200/60 bg-gradient-to-b from-slate-50 to-white py-12 sm:py-16">
        <div class="container-page">
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Jelajahi Negeri</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-2 tracking-tight">Destinasi Wisata</h1>
            <p class="mt-3 text-base sm:text-lg text-slate-600 max-w-2xl font-light">
                Dari dataran tinggi pegunungan hingga pesona terumbu karang — temukan wilayah dan keindahan lokasi liburan Anda berikutnya.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('destinations.index') }}" method="GET" class="mt-8 max-w-lg">
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-slate-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama destinasi atau wilayah..." 
                           class="w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-12 pr-10 text-sm text-slate-900 placeholder-slate-400 shadow-sm transition duration-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                    
                    @if(request('search'))
                        <a href="{{ route('destinations.index') }}" 
                           class="absolute right-3.5 text-slate-400 hover:text-slate-600 transition"
                           title="Bersihkan pencarian">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Destinations Grid Section --}}
    <section class="container-page py-12 sm:py-16">
        @if ($destinations->isEmpty())
            <div class="p-12 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <x-empty-state 
                    title="Destinasi Tidak Ditemukan" 
                    description="Coba cari dengan kata kunci lain atau lihat seluruh daftar destinasi." />
                @if(request('search'))
                    <div class="mt-6">
                        <a href="{{ route('destinations.index') }}" 
                           class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white shadow hover:bg-slate-800 transition duration-200">
                            Lihat Semua Destinasi
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach ($destinations as $destination)
                    <x-destination-card :destination="$destination" />
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $destinations->links() }}
            </div>
        @endif
    </section>
</x-app-layout>