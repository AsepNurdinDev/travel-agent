<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Toyota Hiace', 'Toyota Avanza', 'Isuzu Elf', 'Mercedes Sprinter']),
            'type' => fake()->randomElement(['Van', 'Minibus', 'Bus', 'MPV']),
            'capacity' => fake()->numberBetween(4, 40),
            'price_per_day' => fake()->numberBetween(50, 300) * 10000,
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
