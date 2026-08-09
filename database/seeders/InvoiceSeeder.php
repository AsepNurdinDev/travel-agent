<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Invoices are created automatically by BookingService when a booking
     * is made (see BookingSeeder), so there is nothing additional to seed
     * here. Kept as a no-op to preserve the seeding order documented in
     * DatabaseSeeder / PROJECT_CONTEXT.md.
     */
    public function run(): void
    {
        //
    }
}
