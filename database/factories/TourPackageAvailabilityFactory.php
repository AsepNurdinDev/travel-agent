<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\TourPackageAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourPackageAvailability>
 */
class TourPackageAvailabilityFactory extends Factory
{
    public function definition(): array
    {
        $departure = fake()->dateTimeBetween('+1 week', '+6 months');
        $nights = fake()->numberBetween(2, 6);

        return [
            'tour_package_id' => TourPackage::factory(),
            'departure_date' => $departure,
            'return_date' => (clone $departure)->modify("+{$nights} days"),
            'quota' => $quota = fake()->numberBetween(10, 30),
            'seats_booked' => fake()->numberBetween(0, (int) ($quota * 0.4)),
            'price_adult_override' => null,
            'price_child_override' => null,
            'price_infant_override' => null,
            'status' => 'open',
        ];
    }
}
