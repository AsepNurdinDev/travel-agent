<x-account-layout title="My Beri Ulasans">
    @if ($reviewableBookings->isNotEmpty())
        <div class="mb-8">
            <h2 class="font-bold text-ink mb-3">Perjalanan yang Menunggu Ulasan</h2>
            <div class="space-y-4" x-data="{ openBooking: null }">
                @foreach ($reviewableBookings as $booking)
                    <div class="card p-5">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase text-primary">{{ $booking->tourPackage->destination->name ?? '' }}</p>
                                <p class="font-bold text-ink">{{ $booking->tourPackage->name }}</p>
                            </div>
                            <button @click="openBooking = openBooking === {{ $booking->id }} ? null : {{ $booking->id }}" class="btn-outline !py-1.5 !px-3 text-xs shrink-0">
                                <span x-text="openBooking === {{ $booking->id }} ? 'Batal' : 'Tulis Ulasan'"></span>
                            </button>
                        </div>

                        <div x-show="openBooking === {{ $booking->id }}" x-cloak x-data="{ rating: 5 }" class="mt-4 border-t border-slate-100 pt-4">
                            <form method="POST" action="{{ route('account.reviews.store') }}">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                <label class="label">Penilaian Anda</label>
                                <div class="flex gap-1 mb-4">
                                    <template x-for="i in 5" :key="i">
                                        <button type="button" @click="rating = i">
                                            <svg class="h-7 w-7" :class="i <= rating ? 'text-accent' : 'text-slate-200'" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118L10.5 15.583a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.285-3.957a1 1 0 00-.362-1.118L2.973 9.386c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69z"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <input type="hidden" name="rating" x-bind:value="rating">

                                <label class="label">Title <span class="text-muted font-normal">(optional)</span></label>
                                <input type="text" name="title" maxlength="255" class="input mb-4" placeholder="Sum up your trip in a few words">

                                <label class="label">Ulasan Anda</label>
                                <textarea name="comment" rows="3" maxlength="2000" required class="input" placeholder="Tell other orang about your experience..."></textarea>

                                <button type="submit" class="btn-primary mt-4">Kirim Ulasan</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h2 class="font-bold text-ink mb-3">Ulasan yang Anda Kirim</h2>
    @if ($myBeri Ulasans->isEmpty())
        <x-empty-state title="No reviews yet" description="Complete a trip to leave your first review." />
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($myBeri Ulasans as $review)
                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase text-primary">{{ $review->tourPackage->name ?? '' }}</p>
                        @if (! $review->is_approved)
                            <span class="badge bg-amber-100 text-amber-700">Pending approval</span>
                        @endif
                    </div>
                    <div class="mt-2"><x-rating :value="$review->rating" /></div>
                    @if ($review->title)
                        <p class="mt-2 font-semibold text-ink">{{ $review->title }}</p>
                    @endif
                    <p class="mt-1 text-sm text-muted">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
    @endif
</x-account-layout>
