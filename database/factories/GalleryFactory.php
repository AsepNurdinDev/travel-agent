<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_package_id' => null,
            'destination_id' => null,
            'title' => fake()->sentence(3),
            'image' => 'gallery/'.fake()->uuid().'.jpg',
            'caption' => fake()->sentence(),
        ];
    }
}
