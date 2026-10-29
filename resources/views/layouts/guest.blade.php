<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Welcome' }} — {{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-ink antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- Panel kiri: pemandangan langit --}}
        <div class="relative hidden flex-col justify-between overflow-hidden bg-gradient-to-b from-ocean-600 via-ocean-500 to-sky-200 p-12 text-white lg:flex">
            <x-sky />
            <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/90 p-1.5 shadow-lg"><img src="{{ asset('img/logo.png') }}" alt="" class="h-full w-full object-contain"></span>
                <span class="text-xl font-extrabold">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
            </a>

            <div class="relative z-10 max-w-md pb-24">
                <p class="text-sm font-bold uppercase tracking-[.2em] text-sun-300">Dipercaya 12.000+ traveler</p>
                <h2 class="font-display mt-3 text-4xl font-extrabold leading-tight">Perjalanan Anda berikutnya di Indonesia dimulai dari sini.</h2>
                <p class="mt-4 text-white/90">Destinasi pilihan, harga transparan, dan tim yang menemani dari pemesanan hingga mendarat.</p>
            </div>

            <span class="tv-bob absolute bottom-28 right-12 z-10 text-5xl" aria-hidden="true">🎈</span>
            <span class="tv-bob absolute bottom-24 left-1/2 z-10 text-4xl" style="animation-delay:-3s" aria-hidden="true">⛵</span>
            <x-wave color="#ffffff" class="absolute inset-x-0 bottom-0 opacity-60" slow />
            <x-wave color="#F8FAFC" class="absolute inset-x-0 bottom-0" />
            <p class="relative z-10 text-xs text-white/80">&copy; {{ now()->year }} {{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</p>
        </div>

        {{-- Panel kanan: form --}}
        <div class="flex items-center justify-center bg-surface p-6 sm:p-12">
            <div class="w-full max-w-sm">
                <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3 lg:hidden">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-ocean-50 p-1.5"><img src="{{ asset('img/logo.png') }}" alt="" class="h-full w-full object-contain"></span>
                    <span class="text-lg font-extrabold text-ink">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
                </a>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
