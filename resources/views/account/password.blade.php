<x-app-layout title="Change Password">
    <div class="card p-6 max-w-2xl">
        <h2 class="font-bold text-ink">Change Password</h2>
        <p class="text-sm text-muted mt-1">Use a strong password you're not using elsewhere.</p>

        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            @csrf
            @method('PUT')

            <div>
                <label class="label">Current Password</label>
                <div class="relative">
                    <input :type="showCurrent ? 'text' : 'password'" name="current_password" class="input pr-10">
                    <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 top-2.5 text-muted"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
            </div>

            <div>
                <label class="label">New Password</label>
                <div class="relative">
                    <input :type="showNew ? 'text' : 'password'" name="password" class="input pr-10">
                    <button type="button" @click="showNew = !showNew" class="absolute right-3 top-2.5 text-muted"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            <div>
                <label class="label">Confirm New Password</label>
                <div class="relative">
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" class="input pr-10">
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-2.5 text-muted"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary">Update Password</button>
                @if (session('status') === 'password-updated')
                    <span class="ml-3 text-sm text-emerald-600">Password updated.</span>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
