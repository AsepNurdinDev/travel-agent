<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->city().' '.fake()->randomElement(['Highlands', 'Bay', 'Island', 'Valley', 'Coast']);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(6),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'description' => fake()->paragraphs(2, true),
            'image' => null,
            'is_active' => true,
        ];
    }
}