<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginWithGoogleNotification;
use App\Services\Customer\CustomerService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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

    public function callback(Request $request) // <-- Tambahkan Request $request di sini
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'password'          => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
            ]);

            // Sinkronkan ke tabel customers
            $this->customerService->findOrCreateByEmail([
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => null,
                'user_id' => $user->id,
            ]);

            event(new Registered($user));
        } else {
            // Jika user sudah ada tetapi google_id belum terisi, hubungkan
            if (! $user->google_id) {
                $user->update([
                    'google_id'         => $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }

            // Pastikan customer service selalu memperbarui user_id untuk user yang aktif
            $this->customerService->findOrCreateByEmail([
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => null,
                'user_id' => $user->id,
            ]);
        }

        // Login session
        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        // Kirim email notifikasi
        $user->notify(new LoginWithGoogleNotification());

        return redirect()->intended(route('account.dashboard'));
    }
}