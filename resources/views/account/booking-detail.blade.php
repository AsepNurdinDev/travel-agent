<x-app-layout title="Detail Pesanan">
    <a href="{{ route('account.bookings') }}" class="inline-flex items-center gap-1.5 text-sm text-muted hover:text-primary mb-4">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Back to Pesanan Saya
    </a>

    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <p class="text-xs font-mono text-muted">{{ $booking->booking_code }}</p>
                <h1 class="text-xl font-bold text-ink">{{ $booking->tourPackage->name }}</h1>
            </div>
            <x-status-badge :status="$booking->status" class="text-sm" />
        </div>

        <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm border-t border-slate-100 pt-5">
            <div><p class="text-muted">Destination</p><p class="font-medium text-ink">{{ $booking->tourPackage->destination->name ?? '—' }}</p></div>
            <div><p class="text-muted">Berangkat</p><p class="font-medium text-ink">{{ optional($booking->availability)->departure_date?->format('d M Y') }}</p></div>
            <div><p class="text-muted">Pulang</p><p class="font-medium text-ink">{{ optional($booking->availability)->return_date?->format('d M Y') }}</p></div>
            <div><p class="text-muted">Booked On</p><p class="font-medium text-ink">{{ $booking->created_at->format('d M Y') }}</p></div>
        </div>

        <div class="mt-5 border-t border-slate-100 pt-5">
            <h3 class="font-semibold text-ink mb-2">Peserta</h3>
            <div class="flex gap-6 text-sm text-muted">
                <span>Dewasa: <span class="text-ink font-medium">{{ $booking->adult_count }}</span></span>
                <span>Anak-anak: <span class="text-ink font-medium">{{ $booking->child_count }}</span></span>
                <span>Bayi: <span class="text-ink font-medium">{{ $booking->infant_count }}</span></span>
            </div>
        </div>

        @if ($booking->items->isNotEmpty())
            <div class="mt-5 border-t border-slate-100 pt-5">
                <h3 class="font-semibold text-ink mb-2">Add-ons</h3>
                <ul class="space-y-1 text-sm text-muted">
                    @foreach ($booking->items as $item)
                        <li class="flex justify-between"><span>{{ $item->name }} × {{ $item->quantity }}</span><span class="text-ink">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($booking->notes)
            <div class="mt-5 border-t border-slate-100 pt-5">
                <h3 class="font-semibold text-ink mb-2">Notes</h3>
                <p class="text-sm text-muted">{{ $booking->notes }}</p>
            </div>
        @endif

        @if (! in_array($booking->status, ['cancelled', 'completed']))
            <div class="mt-6 border-t border-slate-100 pt-5 flex flex-wrap gap-3">
                @if ((float) $booking->balance_due > 0)
                    <a href="{{ route('booking.checkout', $booking) }}" class="btn-accent">Pay Sisa Pembayaran</a>
                @endif
                <form method="POST" action="{{ route('account.bookings.cancel', $booking) }}"
                      onsubmit="return confirm('Batal this booking? This cannot be undone.');">
                    @csrf
                    <button type="submit" class="btn-outline !border-red-200 !text-red-600 hover:!border-red-400">Batalkan Pesanan</button>
                </form>
            </div>
        @endif
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-price-breakdown :booking="$booking" />

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-ink">Pembayaran History</h3>
                @if ($booking->invoice)
                    <a href="{{ route('account.invoices.show', $booking->invoice) }}" class="text-sm text-primary font-medium hover:underline">Lihat Tagihan</a>
                @endif
            </div>
            <div class="mt-4 space-y-2">
                @forelse ($booking->payments as $payment)
                    <x-payment-card :payment="$payment" />
                @empty
                    <p class="text-sm text-muted">No payments recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
