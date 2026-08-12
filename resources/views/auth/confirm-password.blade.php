<x-guest-layout title="Confirm Password">
    <h1 class="text-2xl font-bold text-ink">Confirm your password</h1>
    <p class="mt-1.5 text-sm text-muted">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="password" class="label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus class="input">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <button type="submit" class="btn-primary w-full">Confirm</button>
    </form>
</x-guest-layout>
