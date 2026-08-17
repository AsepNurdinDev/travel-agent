@props(['booking'])
<a href="{{ route('account.bookings.show', $booking) }}" class="card flex flex-col sm:flex-row gap-4 p-4 hover:shadow-lg transition">
    <img src="{{ $booking->tourPackage->cover_image ? asset('storage/'.$booking->tourPackage->cover_image) : 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=300&q=60' }}"
         class="h-32 sm:h-auto sm:w-40 shrink-0 rounded-lg object-cover" alt="">
    <div class="flex-1 min-w-0">
        <div class="flex items-start justify-between gap-2">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase text-primary truncate">{{ $booking->tourPackage->destination->name ?? '' }}</p>
                <h3 class="font-bold text-ink truncate">{{ $booking->tourPackage->name }}</h3>
            </div>
            <x-status-badge :status="$booking->status" class="shrink-0" />
        </div>
        <p class="mt-1 text-xs font-mono text-muted">{{ $booking->booking_code }}</p>
        <div class="mt-3 flex flex-wrap gap-x-6 gap-y-1 text-sm text-muted">
            <span>Berangkat: <span class="text-ink font-medium">{{ optional($booking->availability)->departure_date?->format('d M Y') }}</span></span>
            <span>Travelers: <span class="text-ink font-medium">{{ $booking->adult_count + $booking->child_count + $booking->infant_count }}</span></span>
            <span>Total: <span class="text-ink font-medium">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></span>
        </div>
        @if ((float) $booking->balance_due > 0 && $booking->status !== 'cancelled')
            <p class="mt-2 text-xs font-semibold text-amber-600">Balance due: Rp {{ number_format($booking->balance_due, 0, ',', '.') }}</p>
        @endif
    </div>
</a>
