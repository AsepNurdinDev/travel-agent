<x-app-layout title="Tentang Kami">
    {{-- Hero Header Section --}}
    <section class="relative overflow-hidden bg-slate-950 py-20 sm:py-28">
        {{-- Soft Glow Backdrop (menggantikan elemen dekoratif melingkar kaku) --}}
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[600px] h-[350px] bg-emerald-500/15 blur-[120px] rounded-full pointer-events-none"></div>

        <img src="https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?w=1600&q=80" 
             class="absolute inset-0 h-full w-full object-cover opacity-20 transform scale-105" 
             alt="Jelajah Indonesia">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
        
        <div class="container-page relative z-10 text-center max-w-3xl mx-auto px-4">
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-4 py-1.5 text-xs font-semibold text-emerald-400 border border-emerald-500/20 mb-5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Cerita & Komitmen Kami
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Mengenal Nusantara Journeys Lebih Dekat
            </h1>
            <p class="mt-4 text-sm sm:text-base text-slate-300 font-normal leading-relaxed max-w-2xl mx-auto">
                {{ \App\Models\Setting::getValue('site_tagline', 'Tim pemandu lokal dan perencana perjalanan yang siap menghadirkan pengalaman liburan jujur, aman, dan berkesan di seluruh Indonesia.') }}
            </p>
        </div>
    </section>

    {{-- Story & Human Grid Section --}}
    <section class="container-page py-14 sm:py-20 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
        {{-- Text Content --}}
        <div class="lg:col-span-6 space-y-4">
            <div class="inline-flex items-center gap-2 text-xs font-bold tracking-wider text-emerald-600 uppercase bg-emerald-50 px-3 py-1 rounded-md">
                Siapa Kami
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                Dari Tim Kecil Hingga Jaringan Wisata Nasional
            </h2>
            <p class="text-slate-600 leading-relaxed text-sm sm:text-base font-normal">
                {{ \App\Models\Setting::getValue('about_story', "Berawal dari sekelompok sahabat yang memandu wisatawan di pulau kelahirannya, kami telah berkembang menjadi agen perjalanan komprehensif yang menjangkau puluhan destinasi. Kami tetap menjalankan setiap tur seperti hari pertama — dengan kepedulian, transparansi, dan kecintaan mendalam pada keindahan Indonesia.") }}
            </p>

            {{-- Quick Bullet Highlights --}}
            <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm font-medium text-slate-700">
                <div class="flex items-center gap-2.5">
                    <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <span>Pemandu Asli Daerah</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <span>Harga Transparan</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <span>Layanan 24/7 Responsif</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                    <span>Perjalanan Terjadwal</span>
                </div>
            </div>
        </div>

        {{-- Dynamic Photo Layout (Terlihat Alami & Modern) --}}
        <div class="lg:col-span-6 relative">
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div class="space-y-3 sm:space-y-4">
                    <img src="https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=600&q=80" 
                         class="rounded-2xl h-48 sm:h-64 w-full object-cover shadow-md hover:shadow-xl transition duration-300" 
                         alt="Destinasi Wisata">
                    <div class="bg-emerald-600 text-white p-4 sm:p-5 rounded-2xl shadow-md">
                        <p class="text-xs font-medium text-emerald-100">Prinsip Kami</p>
                        <p class="text-sm sm:text-base font-semibold mt-1">"Liburan nyaman tanpa khawatir kendala teknis."</p>
                    </div>
                </div>
                <div class="pt-6 space-y-3 sm:space-y-4">
                    <div class="bg-slate-900 text-white p-4 sm:p-5 rounded-2xl shadow-md">
                        <span class="text-2xl sm:text-3xl font-extrabold text-emerald-400">100%</span>
                        <p class="text-xs text-slate-300 mt-0.5">Lokal & Terverifikasi</p>
                    </div>
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80" 
                         class="rounded-2xl h-48 sm:h-64 w-full object-cover shadow-md hover:shadow-xl transition duration-300" 
                         alt="Peserta Tour Wisata">
                </div>
            </div>
        </div>
    </section>

    {{-- Value Proposition Section (Kenapa Memilih Kami) --}}
    <section class="bg-slate-50 border-y border-slate-200/60 py-14 sm:py-20">
        <div class="container-page max-w-5xl mx-auto">
            <div class="text-center max-w-xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Komitmen Layanan Kami</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">Dua pilar utama yang menjadi landasan setiap perjalanan Anda bersama kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Mission Card --}}
                <div class="rounded-2xl bg-white p-6 sm:p-8 border border-slate-200/80 shadow-sm hover:border-emerald-300 transition duration-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Misi Kami</h3>
                            <p class="text-xs text-slate-400">Fokus pada Eksekusi Perjalanan</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed font-normal">
                        {{ \App\Models\Setting::getValue('about_mission', 'Menyediakan layanan perjalanan yang terencana dengan matang, transparan, dan andal di seluruh Indonesia — mulai dari klik pertama hingga hari terakhir liburan Anda.') }}
                    </p>
                </div>

                {{-- Vision Card --}}
                <div class="rounded-2xl bg-white p-6 sm:p-8 border border-slate-200/80 shadow-sm hover:border-emerald-300 transition duration-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-100 text-teal-700 shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Visi Kami</h3>
                            <p class="text-xs text-slate-400">Tujuan Jangka Panjang</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed font-normal">
                        {{ \App\Models\Setting::getValue('about_vision', 'Menjadi mitra perjalanan terpercaya untuk mengeksplorasi kekayaan pulau, budaya, dan alam Indonesia melalui perjalanan yang dikelola secara profesional.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Natural Stats Banner --}}
    <section class="container-page py-12 sm:py-16">
        <div class="bg-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 divide-y lg:divide-y-0 lg:divide-x divide-slate-800">
                @foreach ([
                    ['value' => $stats['destinations'], 'label' => 'Destinasi Wisata', 'desc' => 'Pilihan rute menarik'],
                    ['value' => $stats['tours'], 'label' => 'Paket Wisata', 'desc' => 'Siap dipesan'],
                    ['value' => $stats['rating'], 'label' => 'Wisatawan', 'desc' => 'Telah bergabung'],
                    ['value' => $stats['avg_rating'] ?: '5.0', 'label' => 'Rating Kepuasan', 'desc' => 'Dari ulasan asli'],
                ] as $index => $s)
                    <div class="{{ $index > 0 ? 'pt-4 lg:pt-0 lg:pl-6' : '' }} text-center sm:text-left">
                        <span class="text-3xl sm:text-4xl font-black text-emerald-400 tracking-tight">
                            {{ $s['value'] }}+
                        </span>
                        <p class="text-sm font-bold text-white mt-1">{{ $s['label'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $s['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Warm CTA Banner Section --}}
    <section class="container-page pb-16 sm:pb-24">
        <div class="rounded-3xl bg-gradient-to-br from-emerald-600 to-teal-800 p-8 sm:p-14 text-center text-white shadow-lg relative overflow-hidden">
            <div class="max-w-xl mx-auto relative z-10 space-y-4">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Siap Memulai Liburan Impian Anda?</h2>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-light">
                    Konsultasikan jadwal atau pilih paket tour yang telah kami siapkan khusus untuk Anda.
                </p>

                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('tours.index') }}" 
                       class="w-full sm:w-auto rounded-xl bg-white px-6 py-3 text-xs sm:text-sm font-bold text-slate-900 shadow-md hover:bg-slate-100 transition active:scale-95">
                        Jelajahi Paket Wisata
                    </a>
                    <a href="{{ route('contact.index') }}" 
                       class="w-full sm:w-auto rounded-xl bg-emerald-700/60 hover:bg-emerald-700/80 px-6 py-3 text-xs sm:text-sm font-bold text-white border border-white/20 transition active:scale-95">
                        Tanya Pemandu Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>