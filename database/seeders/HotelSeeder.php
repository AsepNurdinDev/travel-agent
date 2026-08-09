<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Destination::all()->each(function (Destination $destination) {
            Hotel::factory()
                ->count(random_int(1, 2))
                ->create(['destination_id' => $destination->id])
                ->each(function (Hotel $hotel) {
                    $hotel->rooms()->saveMany(
                        \App\Models\HotelRoom::factory()->count(3)->make()
                    );
                });
        });
    }
}
