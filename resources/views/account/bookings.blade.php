<x-app-layout title="Pesanan Saya">
    <div class="flex gap-1 overflow-x-auto border-b border-slate-200 mb-6">
        @foreach (['all' => 'All', 'upcoming' => 'Upcoming', 'completed' => 'Completed', 'cancelled' => 'Batalled'] as $key => $label)
            <a href="{{ route('account.bookings', ['tab' => $key]) }}"
               class="shrink-0 border-b-2 px-4 py-2.5 text-sm font-medium {{ $tab === $key ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-ink' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($bookings->isEmpty())
        <x-empty-state title="No bookings here" description="Nothing to show in this tab yet.">
            <x-slot:action>
                <a href="{{ route('tours.index') }}" class="btn-primary">Browse Paket Wisata</a>
            </x-slot:action>
        </x-empty-state>
    @else
        <div class="space-y-4">
            @foreach ($bookings as $booking)
                <x-booking-summary :booking="$booking" />
            @endforeach
        </div>
        <div class="mt-8">{{ $bookings->links() }}</div>
    @endif
</x-app-layout>
