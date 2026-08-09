<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\BookingItem>
 */
class BookingItemFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = fake()->numberBetween(5, 30) * 10000;
        $qty = fake()->numberBetween(1, 3);

        return [
            'booking_id' => Booking::factory(),
            'tour_package_addon_id' => null,
            'name' => fake()->randomElement(['Airport Pickup', 'Travel Insurance', 'Extra Night Stay']),
            'unit_price' => $unitPrice,
            'quantity' => $qty,
            'subtotal' => $unitPrice * $qty,
        ];
    }
}
