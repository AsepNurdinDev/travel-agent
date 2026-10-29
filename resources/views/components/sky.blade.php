@props(['plane' => true])
{{-- Dekorasi langit: matahari, awan berjalan, pesawat. Letakkan di dalam elemen "relative overflow-hidden". --}}
<div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
    <span class="tv-bob absolute right-[8%] top-10 h-20 w-20 rounded-full bg-sun-300 shadow-[0_0_70px_26px_rgba(255,178,122,.5)]"></span>
    <span class="tv-drift absolute left-0 top-12 text-5xl opacity-70">☁️</span>
    <span class="tv-drift absolute left-0 top-32 text-4xl opacity-50" style="animation-duration:100s;animation-delay:-40s">☁️</span>
    @if ($plane)
        <div class="tv-fly absolute left-0 top-20 hidden items-center sm:flex">
            <div class="h-0.5 w-32 border-t-2 border-dashed border-white/60"></div>
            <svg viewBox="0 0 64 64" class="h-9 w-9 drop-shadow-lg"><path fill="#fff" d="M60 32 40 24 28 6h-6l6 18H12l-6-8H2l4 16-4 16h4l6-8h16l-6 18h6l12-18 20-8c3-1 3-3 0-4Z"/></svg>
        </div>
    @endif
</div>
