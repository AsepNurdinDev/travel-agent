<x-guest-layout title="Create Account">
    <h1 class="text-2xl font-bold text-ink">Create your account</h1>
    <p class="mt-1.5 text-sm text-muted">Join to book trips and track your bookings in one place.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4" x-data="{ password: '', showPassword: false }">
        @csrf

        <div>
            <label for="name" class="label">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="input">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label for="phone" class="label">Phone Number</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="input">
            <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
        </div>

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="label">Password</label>
            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" x-model="password" required autocomplete="new-password" class="input pr-10">
                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-muted hover:text-ink" tabindex="-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>
            <div class="mt-1.5 flex gap-1" x-show="password.length > 0" x-cloak>
                <template x-for="i in 4">
                    <div class="h-1 flex-1 rounded-full"
                         :class="(password.length >= i * 3) ? (password.length < 8 ? 'bg-red-400' : password.length < 12 ? 'bg-amber-400' : 'bg-emerald-500') : 'bg-slate-200'"></div>
                </template>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="input">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <label class="flex items-start gap-2">
            <input type="checkbox" required class="mt-0.5 h-4 w-4 rounded text-primary focus:ring-primary">
            <span class="text-sm text-muted">I agree to the <span class="font-medium text-primary">Terms of Service</span> and <span class="font-medium text-primary">Privacy Policy</span>.</span>
        </label>

        <button type="submit" class="btn-primary w-full">Create Account</button>
    </form>

    <p class="mt-6 text-center text-sm text-muted">
        Already have an account? <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Log in</a>
    </p>
</x-guest-layout>
