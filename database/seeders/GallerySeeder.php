<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Gallery;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        TourPackage::query()->inRandomOrder()->limit(10)->get()->each(function (TourPackage $package) {
            Gallery::factory()->count(3)->create(['tour_package_id' => $package->id]);
        });

        Destination::query()->inRandomOrder()->limit(5)->get()->each(function (Destination $destination) {
            Gallery::factory()->count(2)->create(['destination_id' => $destination->id]);
        });
    }
}
