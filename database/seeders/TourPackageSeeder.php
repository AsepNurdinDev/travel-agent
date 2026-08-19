<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = Destination::all();

        if ($destinations->isEmpty()) {
            $destinations = Destination::factory()->count(5)->create();
        }

        // Exactly 10 tour packages total, spread across whichever destinations exist.
        collect(range(1, 10))->each(function () use ($destinations) {
            $package = TourPackage::factory()
                ->create(['destination_id' => $destinations->random()->id]);

            $package->images()->saveMany(
                \App\Models\TourPackageImage::factory()->count(3)->make()
            );
            $package->itineraries()->saveMany(
                collect(range(1, $package->duration_days))->map(
                    fn ($day) => \App\Models\TourPackageItinerary::factory()->make(['day_number' => $day])
                )
            );
            $package->inclusions()->saveMany(
                \App\Models\TourPackageInclusion::factory()->count(4)->make()
            );
            $package->exclusions()->saveMany(
                \App\Models\TourPackageExclusion::factory()->count(3)->make()
            );
            $package->addons()->saveMany(
                \App\Models\TourPackageAddon::factory()->count(3)->make()
            );
            $package->availabilities()->saveMany(
                \App\Models\TourPackageAvailability::factory()->count(3)->make([
                    'tour_package_id' => $package->id,
                ])
            );
        });
    }
}
