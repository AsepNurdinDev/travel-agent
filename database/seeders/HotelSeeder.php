<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = Destination::all();

        // Exactly 10 hotels total, spread across whichever destinations exist.
        collect(range(1, 10))->each(function () use ($destinations) {
            $hotel = Hotel::factory()
                ->create(['destination_id' => $destinations->random()->id]);

            $hotel->rooms()->saveMany(
                \App\Models\HotelRoom::factory()->count(3)->make()
            );
        });
    }
}
