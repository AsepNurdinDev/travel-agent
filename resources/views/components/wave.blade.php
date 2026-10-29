@props(['color' => '#F8FAFC', 'slow' => false])

<div {{ $attributes->merge(['class' => 'overflow-hidden leading-[0] pointer-events-none']) }} aria-hidden="true">
    <svg class="tv-wave {{ $slow ? 'tv-wave-slow' : '' }}" viewBox="0 0 2880 120" preserveAspectRatio="none" height="90">
        <path fill="{{ $color }}" d="M0 60C360 0 1080 120 1440 60C1800 0 2520 120 2880 60V120H0Z"/>
    </svg>
</div>
