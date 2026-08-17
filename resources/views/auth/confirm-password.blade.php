<x-guest-layout title="Konfirmasi Kata Sandi">
    <h1 class="text-2xl font-bold text-ink">Konfirmasi kata sandi Anda</h1>
    <p class="mt-1.5 text-sm text-muted">Ini adalah halaman aman. Silakan konfirmasi kata sandi sebelum melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="password" class="label">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus class="input">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn-primary w-full">Konfirmasi</button>
    </form>
</x-guest-layout>
