<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters: every seeder after UserSeeder assumes its foreign-key
     * dependencies already exist (see PROJECT_CONTEXT.md for the intended
     * dependency chain).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          // roles, permissions, staff accounts
            DestinationSeeder::class,
            TourPackageSeeder::class,   // + images/itineraries/inclusions/exclusions/addons/availabilities
            HotelSeeder::class,         // + rooms
            VehicleSeeder::class,
            CustomerSeeder::class,
            PromotionSeeder::class,
            BookingSeeder::class,       // also creates booking items + invoices via BookingService
            PaymentSeeder::class,
            InvoiceSeeder::class,       // no-op, invoices already created above
            ReviewSeeder::class,
            BlogSeeder::class,
            GallerySeeder::class,
            InquirySeeder::class,
        ]);
    }
}
