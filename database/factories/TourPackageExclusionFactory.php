<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\TourPackageExclusion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourPackageExclusion>
 */
class TourPackageExclusionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_package_id' => TourPackage::factory(),
            'description' => fake()->randomElement([
                'Personal expenses', 'Travel insurance', 'International flights',
                'Tipping/gratuities', 'Optional activities', 'Visa fees',
            ]),
            'sort_order' => fake()->numberBetween(0, 5),
        ];
    }
}
