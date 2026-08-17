<x-guest-layout title="Atur Ulang Kata Sandi">
    <h1 class="text-2xl font-bold text-ink">Set a new password</h1>
    <p class="mt-1.5 text-sm text-muted">Gunakan kata sandi yang kuat dan belum pernah digunakan sebelumnya.</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="input">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="label">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="input">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="label">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn-primary w-full">Atur Ulang Kata Sandi</button>
    </form>
</x-guest-layout>
