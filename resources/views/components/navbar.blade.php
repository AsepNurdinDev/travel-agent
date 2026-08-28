@php
    $navLinks = [
        'home' => ['label' => 'Beranda', 'route' => 'home'],
        'destinations' => ['label' => 'Destinasi', 'route' => 'destinations.index'],
        'tours' => ['label' => 'Paket Wisata', 'route' => 'tours.index'],
        'blog' => ['label' => 'Blog', 'route' => 'blog.index'],
        'gallery' => ['label' => 'Galeri', 'route' => 'gallery.index'],
        'about' => ['label' => 'Tentang Kami', 'route' => 'about'],
        'contact' => ['label' => 'Kontak', 'route' => 'contact.index'],
    ];
@endphp

{{-- Header Utama --}}
<header x-data="{ scrolled: false }" x-init="scrolled = window.scrollY > 15;
window.addEventListener('scroll', () => scrolled = window.scrollY > 15)"
    :class="{
        'bg-white/95 backdrop-blur-xl shadow-lg shadow-slate-900/5 border-slate-200/80 py-2.5': scrolled,
        'bg-white/80 backdrop-blur-md border-transparent py-4': !scrolled
    }"
    class="sticky top-0 z-40 border-b transition-all duration-300 ease-out">

    <nav class="container-page flex items-center justify-between" aria-label="Navigasi utama">

        {{-- Brand Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0 focus:outline-none">
            <div
                class="relative flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-slate-50 border border-slate-200/60 p-1.5 shadow-sm transition-all duration-300 group-hover:scale-105 group-hover:border-emerald-500/30 group-hover:shadow-md group-hover:shadow-emerald-500/10">
                <img src="{{ asset('img/logo.png') }}"
                    alt="{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}"
                    class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-110">
            </div>
            <span
                class="text-lg font-bold tracking-tight text-slate-900 group-hover:text-emerald-600 transition-colors duration-300">
                {{ \App\Models\Setting::getValue('site_name', 'Gaskeun') }}
            </span>
        </a>

        {{-- Desktop Navigation Links --}}
        <div
            class="hidden lg:flex items-center gap-1 rounded-full bg-slate-100/80 p-1.5 border border-slate-200/60 backdrop-blur-md shadow-inner">
            @foreach ($navLinks as $key => $link)
                @php $isActive = request()->routeIs($link['route'].'*'); @endphp
                <a href="{{ route($link['route']) }}"
                    class="relative rounded-full px-4 py-1.5 text-xs font-semibold transition-all duration-300 ease-out {{ $isActive ? 'text-emerald-700 font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}">
                    @if ($isActive)
                        <span class="absolute inset-0 rounded-full bg-white transition-all duration-300"></span>
                    @endif
                    <span class="relative z-10">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>

        {{-- Desktop Auth / Account Actions --}}
        <div class="hidden lg:flex items-center gap-3">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-2.5 rounded-full border border-slate-200/80 bg-white/80 p-1 pr-3 text-xs font-semibold text-slate-800 shadow-sm transition-all duration-300 hover:border-emerald-500/40 hover:shadow-md hover:bg-white focus:outline-none">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="max-w-[100px] truncate">{{ Str::of(auth()->user()->name)->before(' ') }}</span>
                        <svg class="h-4 w-4 text-slate-400 transition-transform duration-300 ease-out"
                            :class="{ 'rotate-180 text-emerald-600': open }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2" x-cloak
                        class="absolute right-0 mt-3 w-56 rounded-2xl border border-slate-100 bg-white p-2 shadow-xl shadow-slate-900/10">

                        <div class="px-3 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('account.dashboard') }}"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 transition duration-200 hover:bg-emerald-50 hover:text-emerald-700">
                            Dashboard
                        </a>
                        <a href="{{ route('account.bookings') }}"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 transition duration-200 hover:bg-emerald-50 hover:text-emerald-700">
                            Pesanan Saya
                        </a>
                        <a href="{{ route('account.profile') }}"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 transition duration-200 hover:bg-emerald-50 hover:text-emerald-700">
                            Profil
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 transition duration-200 hover:bg-emerald-50 hover:text-emerald-700">
                            Pengaturan Akun
                        </a>

                        <div class="my-1 border-t border-slate-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold text-rose-600 transition duration-200 hover:bg-rose-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="text-xs font-semibold text-slate-700 hover:text-emerald-600 px-3 py-2 transition duration-200">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 px-5 py-2 text-xs font-semibold text-white shadow-md shadow-emerald-500/20 hover:from-emerald-500 hover:to-teal-500 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300">
                    Daftar
                </a>
            @endauth
        </div>

        {{-- Mobile Hamburger Button (Mengirim Event Global ke Alpine) --}}
        <button @click="$dispatch('toggle-mobile-menu')"
            class="lg:hidden relative h-10 w-10 rounded-xl bg-slate-100 border border-slate-200/80 text-slate-700 hover:bg-slate-200/70 transition-colors duration-200 focus:outline-none flex items-center justify-center shrink-0"
            aria-label="Toggle Navigation">
            <svg class="h-6 w-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>
</header>

{{-- DILETAKKAN DI LUAR TAG HEADER --}}
<x-mobile-menu :links="$navLinks" />
