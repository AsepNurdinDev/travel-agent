<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Customer\CustomerService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(24)),
                // Google sudah verifikasi email pemiliknya sendiri
                'email_verified_at' => now(),
            ]);

            // sinkronkan ke tabel customers, sama seperti registrasi manual
            $this->customerService->findOrCreateByEmail([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => null, // Google tidak kasih nomor telepon
                'user_id' => $user->id,
            ]);

            event(new Registered($user));
        } elseif (! $user->google_id) {
            // user lama yang daftar manual, sekarang login pakai google, link akunnya
            $user->update([
                'google_id' => $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            // user lama ini kemungkinan sudah punya record Customer dari registrasi awal,
            // tapi jaga-jaga kalau belum ada (misal dulu dibuat manual lewat seeder/tinker)
            $this->customerService->findOrCreateByEmail([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => null,
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/account');
    }
}