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
        <div class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-primary p-12 text-white">
            <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/15 font-bold">N</span>
                <span class="text-lg font-bold">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
            </a>

            <div class="relative z-10 max-w-md">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary-100">Trusted by 12,000+ orang</p>
                <h2 class="mt-3 text-3xl font-bold leading-snug">Perjalanan Anda berikutnya di Indonesia dimulai dari sini.</h2>
                <p class="mt-4 text-primary-100">Curated destinations, transparent pricing, and a support team that's with you from booking to landing.</p>
            </div>

            <p class="relative z-10 text-xs text-primary-100">&copy; {{ now()->year }} {{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</p>

            <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-white/10"></div>
            <div class="absolute -top-16 -left-10 h-64 w-64 rounded-full bg-white/10"></div>
        </div>

        <div class="flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-sm">
                <a href="{{ route('home') }}" class="mb-8 flex items-center gap-2 lg:hidden">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white font-bold">N</span>
                    <span class="text-lg font-bold text-ink">{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</span>
                </a>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
