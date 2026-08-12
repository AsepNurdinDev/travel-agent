<x-app-layout title="Profile">
    <div class="card p-6 max-w-2xl">
        <h2 class="font-bold text-ink">Personal Information</h2>
        <p class="text-sm text-muted mt-1">This information is used for your bookings and travel documents.</p>

        <form method="POST" action="{{ route('account.profile.update') }}" class="mt-6 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="label">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $customer->name ?? auth()->user()->name) }}" required maxlength="255" class="input">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label class="label">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled class="input bg-slate-50 text-muted">
                <p class="mt-1 text-xs text-muted">To change your email, go to <a href="{{ route('profile.edit') }}" class="text-primary hover:underline">Account Settings</a>.</p>
            </div>

            <div>
                <label class="label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" required maxlength="20" class="input">
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <div>
                <label class="label">Address</label>
                <textarea name="address" rows="2" maxlength="500" class="input">{{ old('address', $customer->address ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="label">ID / Passport Number</label>
                    <input type="text" name="identity_number" value="{{ old('identity_number', $customer->identity_number ?? '') }}" maxlength="50" class="input">
                    <x-input-error :messages="$errors->get('identity_number')" class="mt-1" />
                </div>
                <div>
                    <label class="label">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($customer->date_of_birth ?? null)->format('Y-m-d')) }}" class="input">
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary">Save Changes</button>
                @if (session('success'))
                    <span class="ml-3 text-sm text-emerald-600">{{ session('success') }}</span>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
