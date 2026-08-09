<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Booking::query()->where('status', 'completed')->get()->each(function (Booking $booking) {
            if (fake()->boolean(60)) {
                Review::factory()->create([
                    'customer_id' => $booking->customer_id,
                    'tour_package_id' => $booking->tour_package_id,
                    'booking_id' => $booking->id,
                ]);
            }
        });

        // A handful of extra standalone reviews so the review list isn't empty
        // even if no booking happened to be marked completed.
        Review::factory()->count(10)->create();
    }
}
