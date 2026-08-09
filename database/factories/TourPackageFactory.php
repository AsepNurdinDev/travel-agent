<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TourPackage>
 */
class TourPackageFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true).' Tour';
        $priceAdult = fake()->numberBetween(15, 60) * 100000;

        return [
            'destination_id' => Destination::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(3, true),
            'duration_days' => $days = fake()->numberBetween(2, 7),
            'duration_nights' => max(1, $days - 1),
            'price_adult' => $priceAdult,
            'price_child' => round($priceAdult * 0.75),
            'price_infant' => round($priceAdult * 0.1),
            'min_participants' => 1,
            'max_participants' => fake()->numberBetween(10, 30),
            'cover_image' => null,
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
            'meta_title' => null,
            'meta_description' => null,
        ];
    }
}
