<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 - Batas Permintaan Terlampaui</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 flex items-center justify-center p-6 font-sans">

    <div
        class="max-w-md w-full text-center bg-white p-8 sm:p-10 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100">

        <!-- Status Code Badge / Icon -->
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-orange-50 text-orange-600 rounded-2xl mb-6 font-bold text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>

        <!-- Heading & Description -->
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
            Terlalu Banyak Permintaan
        </h1>

        <p class="mt-3 text-slate-500 text-sm sm:text-base leading-relaxed">
            Maaf, Anda telah melakukan terlalu banyak permintaan dalam waktu singkat. Harap tunggu beberapa saat sebelum
            mencoba kembali.
        </p>

        <!-- Divider Line -->
        <div class="my-8 border-t border-slate-100"></div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.location.reload()"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-medium text-sm rounded-lg transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Coba Lagi
            </button>

            <a href="{{ url('/') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-lg border border-slate-200 transition-colors">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</body>

</html>
