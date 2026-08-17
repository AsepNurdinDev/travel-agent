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
<header x-data="{ scrolled: false, mobileOpen: false }"
        x-init="scrolled = window.scrollY > 8; window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
        :class="scrolled ? 'bg-white/95 shadow-sm backdrop-blur' : 'bg-white/70 backdrop-blur'"
        class="sticky top-0 z-40 border-b border-slate-100 transition-colors">
    <nav class="container-page flex h-16 items-center justify-between" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white font-bold">N</span>
            <span class="text-lg font-bold text-ink">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
        </a>

        <div class="hidden lg:flex items-center gap-1">
            @foreach ($navLinks as $key => $link)
                <a href="{{ route($link['route']) }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs($link['route'].'*') ? 'text-primary' : 'text-ink hover:text-primary' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden lg:flex items-center gap-3">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 rounded-full border border-slate-200 py-1.5 pl-1.5 pr-3 text-sm font-medium text-ink hover:border-primary">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary-100 text-primary font-semibold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        {{ Str::of(auth()->user()->name)->before(' ') }}
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute right-0 mt-2 w-52 rounded-xl border border-slate-100 bg-white py-2 shadow-card">
                        <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-ink hover:bg-primary-50 hover:text-primary">Akun Saya</a>
                        <a href="{{ route('account.bookings') }}" class="block px-4 py-2 text-sm text-ink hover:bg-primary-50 hover:text-primary">Pesanan Saya</a>
                        <a href="{{ route('account.profile') }}" class="block px-4 py-2 text-sm text-ink hover:bg-primary-50 hover:text-primary">Profil</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-ink hover:bg-primary-50 hover:text-primary">Pengaturan Akun</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
            @endauth
        </div>

        <button @click="mobileOpen = true" class="lg:hidden p-2 text-ink" aria-label="Open menu">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    <x-mobile-menu :links="$navLinks" />
</header>
