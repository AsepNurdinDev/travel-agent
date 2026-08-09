<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'destination_id' => Destination::factory(),
            'name' => fake()->company().' Hotel',
            'address' => fake()->address(),
            'star_rating' => fake()->numberBetween(2, 5),
            'description' => fake()->paragraph(),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }
}
