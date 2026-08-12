<x-app-layout title="Account Settings">
    <div class="container-page py-10 max-w-2xl">
        <p class="section-eyebrow">Security</p>
        <h1 class="section-title !text-2xl">Account Settings</h1>
        <p class="mt-2 text-sm text-muted">Manage your login email and password. For phone, address and other travel details, visit your <a href="{{ route('account.profile') }}" class="text-primary font-medium hover:underline">Profile</a>.</p>

        <div class="mt-8 space-y-6">
            <div class="card p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="card p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
