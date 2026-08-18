<x-app-layout title="Tentang Kami">
    {{-- Hero Header Section --}}
    <section class="relative overflow-hidden bg-slate-950 py-24 sm:py-32">
        <img src="https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?w=1600&q=80" 
             class="absolute inset-0 h-full w-full object-cover opacity-30 transform scale-105 transition-transform duration-1000" 
             alt="Tentang Nusantara Journeys">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-950/30"></div>
        
        <div class="container-page relative z-10 text-center max-w-3xl mx-auto">
            <span class="inline-block rounded-full bg-emerald-500/20 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-300 backdrop-blur-md border border-emerald-500/30 mb-4">
                Cerita Kami
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Dibuat oleh Lokal, untuk Semua Penjelajah
            </h1>
            <p class="mt-4 text-base sm:text-lg text-slate-300 font-light leading-relaxed">
                {{ \App\Models\Setting::getValue('site_tagline', 'Tim pemandu lokal dan perencana perjalanan yang siap menghadirkan pengalaman liburan jujur, aman, dan berkesan di seluruh Indonesia.') }}
            </p>
        </div>
    </section>

    {{-- Story & Image Grid Section --}}
    <section class="container-page py-16 sm:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 sm:gap-16 items-center">
        <div>
            <span class="text-xs font-bold tracking-widest text-emerald-600 uppercase">Perjalanan Kami</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2 tracking-tight leading-snug">
                Dari Tim Kecil Hingga Jaringan Wisata Nasional
            </h2>
            <p class="mt-5 text-slate-600 leading-relaxed font-light text-base sm:text-lg">
                {{ \App\Models\Setting::getValue('about_story', "Berawal dari sekelompok sahabat yang memandu wisatawan di pulau kelahirannya, kami telah berkembang menjadi agen perjalanan komprehensif yang menjangkau puluhan destinasi. Kami tetap menjalankan setiap tur seperti hari pertama — dengan kepedulian, transparansi, dan kecintaan mendalam pada keindahan Indonesia.") }}
            </p>
        </div>

        {{-- Staggered Image Gallery --}}
        <div class="grid grid-cols-2 gap-4 sm:gap-6">
            <div class="space-y-4">
                <img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=80" 
                     class="rounded-3xl h-64 sm:h-72 w-full object-cover shadow-lg shadow-slate-200 transition duration-300 hover:scale-[1.02]" 
                     alt="Keindahan Wisata Indonesia">
            </div>
            <div class="pt-8 space-y-4">
                <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80" 
                     class="rounded-3xl h-64 sm:h-72 w-full object-cover shadow-lg shadow-slate-200 transition duration-300 hover:scale-[1.02]" 
                     alt="Peserta Tour Wisata">
            </div>
        </div>
    </section>

    {{-- Mission & Vision Section --}}
    <section class="bg-slate-50 border-y border-slate-200/60 py-16 sm:py-20">
        <div class="container-page grid grid-cols-1 sm:grid-cols-2 gap-8">
            {{-- Mission Card --}}
            <div class="rounded-3xl bg-white p-8 border border-slate-100 shadow-sm transition hover:shadow-xl hover:shadow-emerald-500/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Misi Kami</h3>
                <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed font-light">
                    {{ \App\Models\Setting::getValue('about_mission', 'Menyediakan layanan perjalanan yang terencana dengan matang, transparan, dan andal di seluruh Indonesia — mulai dari klik pertama hingga hari terakhir liburan Anda.') }}
                </p>
            </div>

            {{-- Vision Card --}}
            <div class="rounded-3xl bg-white p-8 border border-slate-100 shadow-sm transition hover:shadow-xl hover:shadow-emerald-500/5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-600 mb-6">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Visi Kami</h3>
                <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed font-light">
                    {{ \App\Models\Setting::getValue('about_vision', 'Menjadi mitra perjalanan terpercaya untuk mengeksplorasi kekayaan pulau, budaya, dan alam Indonesia melalui perjalanan yang dikelola secara profesional.') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="container-page py-16 sm:py-20">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8">
            @foreach ([
                ['value' => $stats['destinations'], 'label' => 'Destinasi Wisata'],
                ['value' => $stats['tours'], 'label' => 'Paket Wisata'],
                ['value' => $stats['rating'], 'label' => 'Wisatawan Puas'],
                ['value' => $stats['avg_rating'] ?: '5.0', 'label' => 'Rating Rata-rata'],
            ] as $s)
                <div class="rounded-2xl bg-white p-6 border border-slate-100 text-center shadow-sm">
                    <p class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        {{ $s['value'] }}+
                    </p>
                    <p class="mt-2 text-xs sm:text-sm font-semibold text-slate-500 uppercase tracking-wider">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA Banner Section --}}
    <section class="container-page pb-20">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-12 sm:px-16 sm:py-16 text-center shadow-2xl shadow-emerald-600/20">
            {{-- Decorative circles --}}
            <div class="absolute -top-12 -right-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>

            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Mari Rencanakan Perjalanan Anda</h2>
                <p class="mt-3 text-sm sm:text-base text-emerald-100 font-light">
                    Jelajahi paket wisata pilihan kami atau hubungi tim kami untuk konsultasi rute liburan impian Anda.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('tours.index') }}" 
                       class="w-full sm:w-auto rounded-xl bg-amber-400 px-7 py-3.5 text-sm font-bold text-slate-900 shadow-lg shadow-amber-400/20 hover:bg-amber-300 transition duration-200">
                        Lihat Paket Wisata
                    </a>
                    <a href="{{ route('contact.index') }}" 
                       class="w-full sm:w-auto rounded-xl bg-white/10 backdrop-blur-md px-7 py-3.5 text-sm font-bold text-white border border-white/20 hover:bg-white/20 transition duration-200">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>