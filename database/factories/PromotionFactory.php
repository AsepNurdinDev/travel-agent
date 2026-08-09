<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['percentage', 'fixed']);

        return [
            'code' => strtoupper(fake()->unique()->bothify('PROMO###')),
            'name' => fake()->words(2, true).' Promo',
            'description' => fake()->sentence(),
            'type' => $type,
            'value' => $type === 'percentage' ? fake()->numberBetween(5, 30) : fake()->numberBetween(50, 500) * 10000,
            'max_discount' => $type === 'percentage' ? fake()->numberBetween(100, 500) * 10000 : null,
            'min_purchase' => fake()->numberBetween(0, 5) * 100000,
            'starts_at' => now()->subDays(5),
            'ends_at' => now()->addMonths(2),
            'usage_limit' => fake()->numberBetween(20, 200),
            'used_count' => 0,
            'is_active' => true,
        ];
    }
}
