@props(['links' => []])
<div x-show="mobileOpen" x-cloak class="lg:hidden">
    <div x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false"
         class="fixed inset-0 z-40 bg-ink/40"></div>

    <div x-show="mobileOpen"
         x-transition:enter="transition transform duration-200"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform duration-150"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 z-50 w-72 bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-ink">Menu</span>
            <button @click="mobileOpen = false" class="p-1 text-muted hover:text-ink" aria-label="Close menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-6 flex flex-col gap-1">
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}" class="rounded-md px-3 py-2.5 text-sm font-medium text-ink hover:bg-primary-50 hover:text-primary">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="mt-6 flex flex-col gap-2 border-t border-slate-100 pt-6">
            @auth
                <a href="{{ route('account.dashboard') }}" class="btn-outline w-full">Akun Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-ghost w-full">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline w-full">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary w-full">Daftar</a>
            @endauth
        </div>
    </div>
</div>
