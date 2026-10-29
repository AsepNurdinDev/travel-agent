@props(['code', 'emoji' => '🧭', 'tabTitle' => 'Error', 'heading' => '', 'message' => '', 'reload' => false, 'reloadLabel' => 'Muat Ulang', 'home' => false, 'back' => false])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tabTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-b from-ocean-600 via-ocean-500 to-sky-200 p-6 font-sans">
    <x-sky />
    <div class="relative z-10 w-full max-w-lg rounded-[2rem] bg-white p-8 text-center shadow-2xl shadow-ocean-900/30 sm:p-10">
        <div class="tv-bob mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-ocean-50 text-4xl">{{ $emoji }}</div>
        <p class="font-display mt-4 text-7xl font-extrabold text-ocean-600">{{ $code }}</p>
        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-navy sm:text-3xl">{{ $heading }}</h1>
        <p class="mt-3 text-sm leading-relaxed text-slate-500 sm:text-base">{{ $message }}</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            @if ($reload)
                <button onclick="window.location.reload()" class="btn btn-accent w-full sm:w-auto">{{ $reloadLabel }}</button>
            @endif
            @if ($home)
                <a href="{{ url('/') }}" class="btn {{ $reload ? 'btn-outline' : 'btn-accent' }} w-full sm:w-auto">Kembali ke Beranda</a>
            @endif
            @if ($back)
                <button onclick="history.back()" class="btn btn-outline w-full sm:w-auto">Kembali</button>
            @endif
        </div>
    </div>
    <x-wave color="#F8FAFC" class="absolute inset-x-0 bottom-0" />
</body>
</html>
