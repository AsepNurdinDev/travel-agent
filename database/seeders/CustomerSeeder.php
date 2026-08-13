<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Login credentials for the seeded test customer, documented here so
     * anyone seeding a fresh environment can log in and see real data:
     *
     *   email:    customer@example.com
     *   password: password
     */
    public function run(): void
    {
        // Random customers with no site account (walk-in / phone bookings
        // entered by staff via Filament) — these are intentionally NOT
        // linked to a User, since they were never meant to log in.
        Customer::factory()->count(24)->create();

        // One fully-wired test account: User -> Customer, so the full
        // register/login/dashboard/bookings/invoices flow can actually be
        // exercised end-to-end after seeding.
        $user = User::query()->firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        Customer::query()->updateOrCreate(
            ['email' => $user->email],
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 1, Bandung, Jawa Barat',
                'identity_number' => '3273010101990001',
                'date_of_birth' => '1995-01-01',
            ]
        );
    }
}
