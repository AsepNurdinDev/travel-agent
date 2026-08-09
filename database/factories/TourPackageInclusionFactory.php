<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\TourPackageInclusion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourPackageInclusion>
 */
class TourPackageInclusionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_package_id' => TourPackage::factory(),
            'description' => fake()->randomElement([
                'Hotel accommodation', 'Daily breakfast', 'Private transportation',
                'English speaking guide', 'Entrance tickets', 'Airport transfer',
            ]),
            'sort_order' => fake()->numberBetween(0, 5),
        ];
    }
}
