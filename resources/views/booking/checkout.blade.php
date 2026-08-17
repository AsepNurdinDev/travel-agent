<x-app-layout title="Pembayaran">
@php
    $balanceDue = (float) $booking->balance_due;
    $depositAmount = round(max($balanceDue * 0.3, min($balanceDue, 100000)), 2);
@endphp
<div class="container-page py-10" x-data="{ paymentType: 'full', method: 'bank_transfer' }">
    <div class="mx-auto max-w-3xl">
        <div class="mb-6 flex items-center gap-2 text-sm text-muted">
            <span class="text-primary font-medium">Pesanan Dibuat</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-primary font-medium">Pembayaran</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span>Konfirmasi</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-3 space-y-6">
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-ink">{{ $booking->tourPackage->name }}</h2>
                        <x-status-badge :status="$booking->status" />
                    </div>
                    <p class="text-sm text-muted mt-1">Kode Pesanan: <span class="font-mono font-medium text-ink">{{ $booking->booking_code }}</span></p>
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-muted">Berangkat</p><p class="font-medium text-ink">{{ $booking->availability->departure_date->format('d M Y') }}</p></div>
                        <div><p class="text-muted">Peserta</p><p class="font-medium text-ink">{{ $booking->adult_count }} Adult, {{ $booking->child_count }} Child, {{ $booking->infant_count }} Infant</p></div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="font-bold text-ink">Pilih Jumlah Pembayaran</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="rounded-xl border-2 p-4 cursor-pointer" :class="paymentType === 'deposit' ? 'border-primary bg-primary-50/50' : 'border-slate-200'">
                            <input type="radio" x-model="paymentType" value="deposit" class="sr-only">
                            <p class="font-semibold text-ink">Bayar Uang Muka</p>
                            <p class="mt-1 text-lg font-bold text-primary">Rp {{ number_format($depositAmount, 0, ',', '.') }}</p>
                            <p class="text-xs text-muted mt-1">Amankan tempat Anda sekarang, sisanya bisa dibayar nanti.</p>
                        </label>
                        <label class="rounded-xl border-2 p-4 cursor-pointer" :class="paymentType === 'full' ? 'border-primary bg-primary-50/50' : 'border-slate-200'">
                            <input type="radio" x-model="paymentType" value="full" class="sr-only">
                            <p class="font-semibold text-ink">Bayar Lunas</p>
                            <p class="mt-1 text-lg font-bold text-primary">Rp {{ number_format($balanceDue, 0, ',', '.') }}</p>
                            <p class="text-xs text-muted mt-1">Selesai — tidak ada pembayaran lagi sebelum keberangkatan.</p>
                        </label>
                    </div>

                    <h3 class="mt-6 font-bold text-ink">Metode Pembayaran</h3>
                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach ([['id'=>'bank_transfer','label'=>'Transfer Bank'],['id'=>'e_wallet','label'=>'Dompet Digital'],['id'=>'credit_card','label'=>'Kartu Kredit']] as $m)
                            <label class="rounded-lg border-2 px-4 py-3 text-center text-sm font-medium cursor-pointer" :class="method === '{{ $m['id'] }}' ? 'border-primary text-primary bg-primary-50/50' : 'border-slate-200 text-ink'">
                                <input type="radio" x-model="method" value="{{ $m['id'] }}" class="sr-only">
                                {{ $m['label'] }}
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-5 rounded-lg bg-amber-50 border border-amber-100 px-4 py-3 text-xs text-amber-800">
                        Pembayaran online akan segera tersedia. Untuk sementara, konfirmasi di halaman ini akan dicatat seperti pembayaran yang diverifikasi oleh tim kami.
                    </div>

                    <form method="POST" action="{{ route('booking.pay', $booking) }}" class="mt-5">
                        @csrf
                        <input type="hidden" name="payment_type" x-bind:value="paymentType">
                        <input type="hidden" name="method" x-bind:value="method">
                        <button type="submit" class="btn-accent w-full">Konfirmasi &amp; Pay</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <x-price-breakdown :booking="$booking" />
            </div>
        </div>
    </div>
</div>
</x-app-layout>
