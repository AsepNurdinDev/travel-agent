<?php

namespace Tests\Feature\Booking;

use App\Models\Promotion;
use App\Models\TourPackage;
use App\Models\TourPackageAddon;
use App\Models\TourPackageAvailability;
use App\Services\Booking\BookingPricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingPricingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_tiered_participant_pricing(): void
    {
        $package = TourPackage::factory()->create([
            'price_adult' => 1000000,
            'price_child' => 750000,
            'price_infant' => 100000,
        ]);

        $availability = TourPackageAvailability::factory()->create([
            'tour_package_id' => $package->id,
            'quota' => 20,
            'seats_booked' => 0,
        ]);

        $result = app(BookingPricingService::class)->calculate(
            availability: $availability,
            adultCount: 2,
            childCount: 1,
            infantCount: 1,
        );

        // 2*1,000,000 + 1*750,000 + 1*100,000 = 2,850,000
        $this->assertSame('2850000.00', $result['subtotal']);
        $this->assertSame('2850000.00', $result['total_amount']);
        $this->assertSame('0.00', $result['discount_amount']);
    }

    public function test_addon_pricing_is_looked_up_server_side_not_trusted_from_input(): void
    {
        $package = TourPackage::factory()->create(['price_adult' => 500000, 'price_child' => 0, 'price_infant' => 0]);
        $availability = TourPackageAvailability::factory()->create(['tour_package_id' => $package->id]);
        $addon = TourPackageAddon::factory()->create(['tour_package_id' => $package->id, 'price' => 50000]);

        $result = app(BookingPricingService::class)->calculate(
            availability: $availability,
            adultCount: 1,
            childCount: 0,
            infantCount: 0,
            addons: [
                // A malicious caller could try to smuggle a fake price here;
                // BookingPricingService must ignore it and use the DB price.
                ['addon_id' => $addon->id, 'quantity' => 2, 'price' => 1],
            ],
        );

        // 500,000 (adult) + 2 * 50,000 (addon, from DB not from input) = 600,000
        $this->assertSame('600000.00', $result['total_amount']);
        $this->assertSame('100000.00', $result['addons_total']);
    }

    public function test_percentage_promotion_is_capped_by_max_discount(): void
    {
        $package = TourPackage::factory()->create(['price_adult' => 1000000, 'price_child' => 0, 'price_infant' => 0]);
        $availability = TourPackageAvailability::factory()->create(['tour_package_id' => $package->id]);

        $promotion = Promotion::factory()->create([
            'type' => 'percentage',
            'value' => 50, // 50% of 1,000,000 = 500,000
            'max_discount' => 200000, // capped
            'min_purchase' => 0,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
            'usage_limit' => null,
        ]);

        $result = app(BookingPricingService::class)->calculate(
            availability: $availability,
            adultCount: 1,
            childCount: 0,
            infantCount: 0,
            promotion: $promotion,
        );

        $this->assertSame('200000.00', $result['discount_amount']);
        $this->assertSame('800000.00', $result['total_amount']);
    }

    public function test_expired_promotion_gives_no_discount(): void
    {
        $package = TourPackage::factory()->create(['price_adult' => 1000000, 'price_child' => 0, 'price_infant' => 0]);
        $availability = TourPackageAvailability::factory()->create(['tour_package_id' => $package->id]);

        $promotion = Promotion::factory()->create([
            'is_active' => true,
            'starts_at' => now()->subDays(10),
            'ends_at' => now()->subDay(), // already ended
        ]);

        $result = app(BookingPricingService::class)->calculate(
            availability: $availability,
            adultCount: 1,
            childCount: 0,
            infantCount: 0,
            promotion: $promotion,
        );

        $this->assertSame('0.00', $result['discount_amount']);
    }
}
