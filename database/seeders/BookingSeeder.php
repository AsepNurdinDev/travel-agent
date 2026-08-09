<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\TourPackageAvailability;
use App\Services\Booking\BookingService;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $bookingService = app(BookingService::class);
        $customers = Customer::all();
        $availabilities = TourPackageAvailability::query()->where('status', 'open')->get();

        if ($customers->isEmpty() || $availabilities->isEmpty()) {
            return;
        }

        foreach (range(1, 20) as $i) {
            $availability = $availabilities->random();
            $customer = $customers->random();

            $adults = random_int(1, 3);
            $children = random_int(0, 2);
            $infants = 0;

            $participants = $adults + $children + $infants;

            if ($availability->remaining_quota < $participants) {
                continue;
            }

            try {
                $bookingService->createBooking(
                    customer: $customer,
                    availability: $availability,
                    adultCount: $adults,
                    childCount: $children,
                    infantCount: $infants,
                );
            } catch (\Throwable) {
                // Skip on any pricing/availability edge case during seeding.
                continue;
            }

            // Refresh remaining quota locally to avoid overbooking in this loop.
            $availability->refresh();
        }
    }
}
