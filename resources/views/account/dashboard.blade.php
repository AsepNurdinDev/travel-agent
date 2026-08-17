<x-app-layout title="Ringkasan">
    <div class="card p-6 bg-gradient-to-r from-primary to-primary-dark text-white">
        <h1 class="text-xl font-bold">Welcome back, {{ Str::of(auth()->user()->name)->before(' ') }} 👋</h1>
        <p class="mt-1 text-primary-100 text-sm">Here's what's happening with your trips.</p>
    </div>

    <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            ['label' => 'Total Bookings', 'value' => $stats['total'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Upcoming Trips', 'value' => $stats['upcoming'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Completed Trips', 'value' => $stats['completed'], 'icon' => 'M5 13l4 4L19 7'],
            ['label' => 'Pending Pembayarans', 'value' => $stats['pending_payment'], 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v-1'],
        ] as $card)
            <div class="card p-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-50 text-primary">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/></svg>
                </div>
                <p class="mt-3 text-2xl font-bold text-ink">{{ $card['value'] }}</p>
                <p class="text-xs text-muted">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    @if ($stats['pending_payment'] > 0)
        <div class="mt-6 rounded-xl bg-amber-50 border border-amber-100 px-5 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                <p class="text-sm text-amber-800">You have {{ $stats['pending_payment'] }} booking(s) with an outstanding balance.</p>
            </div>
            <a href="{{ route('account.bookings') }}" class="btn-accent !py-1.5 !px-3 text-xs shrink-0">Beri Ulasan</a>
        </div>
    @endif

    @if ($upcomingBooking)
        <div class="mt-8">
            <h2 class="text-lg font-bold text-ink mb-3">Perjalanan Berikutnya</h2>
            <x-booking-summary :booking="$upcomingBooking" />
        </div>
    @endif

    <div class="mt-8">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-bold text-ink">Recent Bookings</h2>
            <a href="{{ route('account.bookings') }}" class="text-sm font-medium text-primary hover:underline">Lihat semua</a>
        </div>

        @if ($recentBookings->isEmpty())
            <x-empty-state title="No bookings yet" description="Ready for your first trip? Browse our tours to get started.">
                <x-slot:action>
                    <a href="{{ route('tours.index') }}" class="btn-primary">Browse Paket Wisata</a>
                </x-slot:action>
            </x-empty-state>
        @else
            <div class="space-y-4">
                @foreach ($recentBookings as $booking)
                    <x-booking-summary :booking="$booking" />
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
