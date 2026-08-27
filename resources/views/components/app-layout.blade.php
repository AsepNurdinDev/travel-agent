<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' — ' : '' }}{{ \App\Models\Setting::getValue('site_name', 'Nusantara Journeys') }}</title>
    @if(isset($metaDescription))
        <meta name="description" content="{{ Str::limit(strip_tags($metaDescription), 160) }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ mobileOpen: false }" class="flex min-h-screen flex-col bg-surface font-sans text-ink">
    <x-navbar />

    <main class="flex-1">
        @if (session('success'))
            <div class="container-page mt-4">
                <div class="rounded-lg bg-primary-50 border border-primary-100 text-primary-800 px-4 py-3 text-sm font-medium" role="status">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container-page mt-4">
                <div class="rounded-lg bg-red-50 border border-red-100 text-red-700 px-4 py-3 text-sm font-medium" role="alert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <x-footer />
</body>
</html>