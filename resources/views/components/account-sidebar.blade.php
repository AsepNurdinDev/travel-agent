@php
    $accountLinks = [
        ['route' => 'account.dashboard', 'label' => 'Ringkasan', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'account.bookings', 'label' => 'Pesanan Saya', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route' => 'account.invoices', 'label' => 'Invoices', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['route' => 'account.reviews', 'label' => 'My Beri Ulasans', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.519-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
        ['route' => 'account.profile', 'label' => 'Profil', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['route' => 'account.password', 'label' => 'Change Kata Sandi', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
    ];
@endphp
<div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-2">
    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-primary-100 text-primary font-bold">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </span>
    <div class="min-w-0">
        <p class="truncate text-sm font-semibold text-ink">{{ auth()->user()->name }}</p>
        <p class="truncate text-xs text-muted">{{ auth()->user()->email }}</p>
    </div>
</div>
<nav class="flex flex-col gap-1 py-2">
    @foreach ($accountLinks as $link)
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($link['route']) ? 'bg-primary text-white' : 'text-ink hover:bg-primary-50 hover:text-primary' }}">
            <svg class="h-[18px] w-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
            </svg>
            {{ $link['label'] }}
        </a>
    @endforeach
</nav>
<form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 pt-2 mt-2">
    @csrf
    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">
        <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        Keluar
    </button>
</form>
