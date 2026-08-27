<x-guest-layout title="Verifikasi Email">
    <div class="mx-auto w-full max-w-md rounded-2xl bg-white p-8 shadow-xl shadow-slate-100/60 border border-slate-100 text-center">
        <!-- Icon Badge with Soft Glow -->
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-50 text-primary ring-8 ring-primary-50/50 transition-transform hover:scale-105">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <!-- Header & Description -->
        <h1 class="mt-6 text-2xl font-bold tracking-tight text-ink">Verifikasi Email Anda</h1>
        <p class="mt-3 text-sm leading-relaxed text-muted">
            Terima kasih sudah mendaftar! Kami telah mengirimkan tautan verifikasi ke email Anda. Silakan periksa kotak masuk atau folder spam.
        </p>

        <!-- Notification Alert -->
        @if (session('status') == 'verification-link-sent')
            <div class="mt-5 flex items-center gap-2 rounded-xl bg-emerald-50 border border-emerald-200/60 p-4 text-left text-xs font-medium text-emerald-800 animate-fade-in">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tautan verifikasi baru telah dikirim ke alamat email Anda.</span>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full py-2.5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 text-sm font-semibold text-muted transition-colors hover:text-rose-600">
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>