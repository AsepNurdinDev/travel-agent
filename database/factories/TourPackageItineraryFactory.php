<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\TourPackageItinerary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourPackageItinerary>
 */
class TourPackageItineraryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_package_id' => TourPackage::factory(),
            'day_number' => fake()->numberBetween(1, 30),
            'title' => 'Day trip: '.fake()->words(3, true),
            'description' => fake()->paragraph(),
        ];
    }
}