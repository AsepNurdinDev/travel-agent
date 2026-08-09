<?php

namespace Tests\Feature\Booking;

use App\Models\Customer;
use App\Models\TourPackage;
use App\Models\TourPackageAvailability;
use App\Services\Booking\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class BookingAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_booking_cannot_exceed_remaining_quota(): void
    {
        $package = TourPackage::factory()->create();
        $availability = TourPackageAvailability::factory()->create([
            'tour_package_id' => $package->id,
            'quota' => 2,
            'seats_booked' => 0,
            'status' => 'open',
        ]);
        $customer = Customer::factory()->create();

        $this->expectException(RuntimeException::class);

        app(BookingService::class)->createBooking(
            customer: $customer,
            availability: $availability,
            adultCount: 3, // more than the quota of 2
            childCount: 0,
            infantCount: 0,
        );
    }

    public function test_a_confirmed_booking_reserves_seats_and_can_fill_the_departure(): void
    {
        $package = TourPackage::factory()->create();
        $availability = TourPackageAvailability::factory()->create([
            'tour_package_id' => $package->id,
            'quota' => 2,
            'seats_booked' => 0,
            'status' => 'open',
        ]);
        $customer = Customer::factory()->create();

        $booking = app(BookingService::class)->createBooking(
            customer: $customer,
            availability: $availability,
            adultCount: 2,
            childCount: 0,
            infantCount: 0,
        );

        $availability->refresh();

        $this->assertSame(2, $availability->seats_booked);
        $this->assertSame('full', $availability->status);
        $this->assertSame('pending', $booking->status);
    }

    public function test_cancelling_a_booking_releases_its_seats(): void
    {
        $package = TourPackage::factory()->create();
        $availability = TourPackageAvailability::factory()->create([
            'tour_package_id' => $package->id,
            'quota' => 2,
            'seats_booked' => 0,
            'status' => 'open',
        ]);
        $customer = Customer::factory()->create();

        $service = app(BookingService::class);
        $booking = $service->createBooking($customer, $availability, 2, 0, 0);

        $service->cancelBooking($booking);

        $availability->refresh();
        $this->assertSame(0, $availability->seats_booked);
        $this->assertSame('open', $availability->status);
        $this->assertSame('cancelled', $booking->fresh()->status);
    }
}
