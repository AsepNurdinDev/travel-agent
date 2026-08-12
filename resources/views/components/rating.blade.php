@props(['value' => 0, 'count' => null, 'size' => 'sm'])
@php $value = round($value ?? 0); $starSize = $size === 'lg' ? 'h-5 w-5' : 'h-4 w-4'; @endphp
<div class="flex items-center gap-1" aria-label="{{ $value }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        <svg class="{{ $starSize }} {{ $i <= $value ? 'text-accent' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.286 3.957c.3.922-.755 1.688-1.538 1.118L10.5 15.583a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.285-3.957a1 1 0 00-.362-1.118L2.973 9.386c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69z"/>
        </svg>
    @endfor
    @if ($count !== null)
        <span class="ml-1 text-xs text-muted">({{ $count }})</span>
    @endif
</div>
