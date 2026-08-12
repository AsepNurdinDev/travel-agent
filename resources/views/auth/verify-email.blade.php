<x-guest-layout title="Verify Email">
    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-50 text-primary">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
    </span>
    <h1 class="mt-4 text-2xl font-bold text-ink">Verify your email</h1>
    <p class="mt-2 text-sm text-muted leading-relaxed">
        Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you. Didn't get it? We can send another.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-4 rounded-lg bg-primary-50 border border-primary-100 px-4 py-3 text-sm font-medium text-primary-800">
            A new verification link has been sent to the email address you provided.
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-muted hover:text-ink">Log Out</button>
        </form>
    </div>
</x-guest-layout>
