<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\TourPackage;
use App\Models\TourPackageAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $availability = TourPackageAvailability::factory();
        $adults = fake()->numberBetween(1, 4);
        $children = fake()->numberBetween(0, 2);
        $infants = fake()->numberBetween(0, 1);

        // NOTE: Seeder-only convenience defaults. In the real application
        // these numbers are always produced by BookingPricingService, never
        // written directly from user input.
        $priceAdult = fake()->numberBetween(15, 60) * 100000;
        $priceChild = round($priceAdult * 0.75);
        $priceInfant = round($priceAdult * 0.1);
        $subtotal = ($adults * $priceAdult) + ($children * $priceChild) + ($infants * $priceInfant);

        return [
            'booking_code' => 'BK-'.strtoupper(Str::random(8)),
            'customer_id' => Customer::factory(),
            'tour_package_id' => TourPackage::factory(),
            'tour_package_availability_id' => $availability,
            'promotion_id' => null,
            'adult_count' => $adults,
            'child_count' => $children,
            'infant_count' => $infants,
            'price_adult' => $priceAdult,
            'price_child' => $priceChild,
            'price_infant' => $priceInfant,
            'addons_total' => 0,
            'subtotal' => $subtotal,
            'discount_amount' => 0,
            'total_amount' => $subtotal,
            'amount_paid' => 0,
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
            'notes' => null,
            'created_by' => null,
        ];
    }
}
