<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\HotelRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HotelRoom>
 */
class HotelRoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'room_type' => fake()->randomElement(['Standard', 'Deluxe', 'Suite', 'Family Room']),
            'capacity' => fake()->numberBetween(1, 4),
            'price_per_night' => fake()->numberBetween(30, 200) * 10000,
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
