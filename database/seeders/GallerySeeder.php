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
        // Exactly 10 galleries total: 6 attached to tour packages, 4 to destinations.
        TourPackage::query()->inRandomOrder()->limit(6)->get()->each(function (TourPackage $package) {
            Gallery::factory()->count(1)->create(['tour_package_id' => $package->id]);
        });

        Destination::query()->inRandomOrder()->limit(4)->get()->each(function (Destination $destination) {
            Gallery::factory()->count(1)->create(['destination_id' => $destination->id]);
        });
    }
}
