@php
    $tabs = [
        [
            'label' => 'Home',
            'route' => 'home',
            'active' => request()->routeIs('home'),
            'href' => route('home'),
            'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ],
        [
            'label' => 'Explore',
            'route' => 'tours.*',
            'active' => request()->routeIs('tours.*') || request()->routeIs('destinations.*'),
            'href' => route('tours.index'),
            'icon' => 'M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z',
        ],
        [
            'label' => 'Bookings',
            'route' => 'account.bookings*',
            'active' => request()->routeIs('account.bookings*') || request()->routeIs('booking.*'),
            'href' => auth()->check() ? route('account.bookings') : route('login'),
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'label' => 'Account',
            'route' => 'account.*',
            'active' => request()->routeIs('account.*') && ! request()->routeIs('account.bookings*'),
            'href' => auth()->check() ? route('account.dashboard') : route('login'),
            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        ],
    ];
@endphp
<nav
    class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-100 bg-white/95 backdrop-blur lg:hidden"
    style="padding-bottom: env(safe-area-inset-bottom);"
    aria-label="Primary"
>
    <div class="grid grid-cols-4">
        @foreach ($tabs as $tab)
            <a href="{{ $tab['href'] }}"
               class="flex flex-col items-center justify-center gap-1 py-2.5 min-h-[52px] text-[11px] font-medium transition {{ $tab['active'] ? 'text-primary' : 'text-muted' }}"
               aria-current="{{ $tab['active'] ? 'page' : 'false' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $tab['active'] ? 2.25 : 1.75 }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}" />
                </svg>
                <span>{{ $tab['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
