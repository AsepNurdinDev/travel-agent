<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\TourPackageAddon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourPackageAddon>
 */
class TourPackageAddonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_package_id' => TourPackage::factory(),
            'name' => fake()->randomElement(['Extra Night Stay', 'Airport Pickup', 'Travel Insurance', 'Private Guide', 'SIM Card']),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(5, 50) * 10000,
            'is_active' => true,
        ];
    }
}
