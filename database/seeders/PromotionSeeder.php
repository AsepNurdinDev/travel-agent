<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::factory()->count(10)->create()->each(function (Promotion $promotion) {
            $promotion->tourPackages()->attach(
                TourPackage::query()->inRandomOrder()->limit(random_int(1, 3))->pluck('id')
            );
        });
    }
}
