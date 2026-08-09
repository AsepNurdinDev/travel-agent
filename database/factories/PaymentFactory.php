<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'payment_code' => 'PAY-'.strtoupper(Str::random(8)),
            'amount' => fake()->numberBetween(10, 60) * 100000,
            'method' => fake()->randomElement(['bank_transfer', 'credit_card', 'e_wallet', 'cash']),
            'status' => 'paid',
            'transaction_id' => strtoupper(Str::random(12)),
            'paid_at' => now(),
            'gateway_response' => null,
            'verified_by' => null,
        ];
    }
}
