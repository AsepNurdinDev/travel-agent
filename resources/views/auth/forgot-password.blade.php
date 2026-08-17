<x-guest-layout title="Lupa Kata Sandi">
    <h1 class="text-2xl font-bold text-ink">Lupa kata sandi?</h1>
    <p class="mt-1.5 text-sm text-muted">No problem — enter your email and we'll send you a reset link.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="email" class="label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn-primary w-full">Email Kata Sandi Reset Link</button>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Kembali ke halaman masuk</a>
    </p>
</x-guest-layout>
