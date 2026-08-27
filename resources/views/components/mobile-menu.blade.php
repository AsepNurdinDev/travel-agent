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
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    {{-- Menu Drawer Kanan dengan background putih solid --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition transform duration-300 ease-out"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform duration-200 ease-in"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 z-50 flex w-72 flex-col justify-between bg-white p-6 shadow-2xl border-l border-slate-100">
        
        <div>
            {{-- Header Menu --}}
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <span class="text-lg font-bold text-slate-900">Menu</span>
                <button @click="mobileOpen = false" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors" aria-label="Close menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Link Navigasi --}}
            <div class="mt-4 flex flex-col gap-1">
                @foreach ($links as $link)
                    @php $isActive = request()->routeIs($link['route'].'*'); @endphp
                    <a href="{{ route($link['route']) }}" 
                       class="rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors {{ $isActive ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Tombol Action / Auth --}}
        <div class="flex flex-col gap-2.5 border-t border-slate-100 pt-5">
            @auth
                <a href="{{ route('account.dashboard') }}" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 text-center text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-rose-50 py-2.5 text-center text-xs font-semibold text-rose-600 hover:bg-rose-100 transition-colors">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 text-center text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 py-2.5 text-center text-xs font-semibold text-white shadow-md shadow-emerald-500/20 hover:from-emerald-500 hover:to-teal-500 transition-all">
                    Daftar
                </a>
            @endauth
        </div>

    </div>
</div>