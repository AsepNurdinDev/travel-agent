@props(['links' => []])

<div x-show="mobileOpen" x-cloak class="relative z-50 lg:hidden">
    {{-- Backdrop Gelap Penutup Content --}}
    <div x-show="mobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    {{-- Menu Drawer Kanan dengan background putih solid --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition transform duration-200 ease-out"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform duration-150 ease-in"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 z-50 flex w-72 flex-col justify-between bg-white p-6 shadow-2xl">
        
        <div>
            {{-- Header Menu --}}
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-ink">Menu</span>
                <button @click="mobileOpen = false" class="p-1 text-muted hover:text-ink" aria-label="Close menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Link Navigasi --}}
            <div class="mt-6 flex flex-col gap-1">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['route'].'*'); @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="rounded-md px-3 py-2.5 text-sm font-medium transition-colors {{ $isActive ? 'bg-primary-50 text-primary font-bold' : 'text-ink hover:bg-primary-50 hover:text-primary' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Tombol Action / Auth --}}
        <div class="flex flex-col gap-2 border-t border-slate-100 pt-6">
            @auth
                <a href="{{ route('account.dashboard') }}" class="btn-outline w-full text-center">Akun Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost w-full">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline w-full text-center">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary w-full text-center">Daftar</a>
            @endauth
        </div>

    </div>
</div>