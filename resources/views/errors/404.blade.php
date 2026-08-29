<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 flex items-center justify-center p-6 font-sans">

    <div
        class="max-w-md w-full text-center bg-white p-8 sm:p-10 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100">

        <!-- Status Code Badge -->
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl mb-6 font-bold text-xl">
            404
        </div>

        <!-- Heading & Description -->
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
            Halaman Tidak Ditemukan
        </h1>

        <p class="mt-3 text-slate-500 text-sm sm:text-base leading-relaxed">
            Maaf, halaman yang Anda cari tidak tersedia, telah dihapus, atau alamat URL yang dimasukkan salah.
        </p>

        <!-- Divider Line -->
        <div class="my-8 border-t border-slate-100"></div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('/') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-gray font-medium text-sm rounded-lg transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>

            <button onclick="history.back()"
                class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-lg border border-slate-200 transition-colors">
                Kembali
            </button>
        </div>

    </div>

</body>

</html>
