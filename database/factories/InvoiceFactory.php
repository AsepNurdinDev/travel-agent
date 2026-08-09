<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'invoice_number' => 'INV-'.now()->format('Ymd').'-'.fake()->unique()->numberBetween(1000, 9999),
            'issued_date' => now(),
            'due_date' => now()->addDays(3),
            'amount' => fake()->numberBetween(10, 60) * 100000,
            'status' => 'unpaid',
            'notes' => null,
        ];
    }
}
