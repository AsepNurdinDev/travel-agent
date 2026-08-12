@props(['review'])
<div class="card p-5">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary font-bold">
                {{ strtoupper(substr($review->customer->name ?? 'A', 0, 1)) }}
            </span>
            <div>
                <p class="text-sm font-semibold text-ink">{{ $review->customer->name ?? 'Traveler' }}</p>
                <p class="text-xs text-muted">{{ $review->created_at?->format('d M Y') }}</p>
            </div>
        </div>
        <x-rating :value="$review->rating" />
    </div>
    @if ($review->title)
        <p class="mt-3 font-semibold text-ink">{{ $review->title }}</p>
    @endif
    <p class="mt-2 text-sm leading-relaxed text-muted">{{ $review->comment }}</p>
</div>
