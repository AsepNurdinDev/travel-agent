<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Customer;
use App\Models\Promotion;
use App\Models\TourPackageAvailability;
use App\Services\Invoice\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    public function __construct(
        private readonly BookingPricingService $pricingService,
        private readonly BookingAvailabilityService $availabilityService,
        private readonly InvoiceService $invoiceService,
    ) {
    }

    /**
     * Create a booking. $addons is trusted only for *which* addon and
     * *quantity* — the price is always re-looked-up server-side by
     * BookingPricingService, never taken from the caller.
     *
     * @param  array<int, array{addon_id: int, quantity: int}>  $addons
     */
    public function createBooking(
        Customer $customer,
        TourPackageAvailability $availability,
        int $adultCount,
        int $childCount,
        int $infantCount,
        array $addons = [],
        ?Promotion $promotion = null,
        ?string $notes = null,
        ?int $createdBy = null,
    ): Booking {
        return DB::transaction(function () use (
            $customer, $availability, $adultCount, $childCount, $infantCount,
            $addons, $promotion, $notes, $createdBy
        ) {
            $pricing = $this->pricingService->calculate(
                $availability, $adultCount, $childCount, $infantCount, $addons, $promotion
            );

            $this->availabilityService->reserveSeats($availability, $adultCount + $childCount + $infantCount);

            $booking = Booking::query()->create([
                'booking_code' => $this->generateBookingCode(),
                'customer_id' => $customer->id,
                'tour_package_id' => $availability->tour_package_id,
                'tour_package_availability_id' => $availability->id,
                'promotion_id' => $promotion?->id,
                'adult_count' => $adultCount,
                'child_count' => $childCount,
                'infant_count' => $infantCount,
                'price_adult' => $pricing['price_adult'],
                'price_child' => $pricing['price_child'],
                'price_infant' => $pricing['price_infant'],
                'addons_total' => $pricing['addons_total'],
                'subtotal' => $pricing['subtotal'],
                'discount_amount' => $pricing['discount_amount'],
                'total_amount' => $pricing['total_amount'],
                'amount_paid' => 0,
                'status' => 'pending',
                'notes' => $notes,
                'created_by' => $createdBy,
            ]);

            foreach ($pricing['items'] as $item) {
                BookingItem::query()->create([
                    'booking_id' => $booking->id,
                    'tour_package_addon_id' => $item['addon_id'],
                    'name' => $item['name'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            if ($promotion) {
                $promotion->increment('used_count');
            }

            $this->invoiceService->createForBooking($booking);

            return $booking->fresh(['items', 'invoice']);
        });
    }

    public function cancelBooking(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            if (in_array($booking->status, ['cancelled', 'completed'], true)) {
                return $booking;
            }

            $this->availabilityService->releaseSeats(
                $booking->availability,
                $booking->adult_count + $booking->child_count + $booking->infant_count
            );

            $booking->update(['status' => 'cancelled']);

            return $booking->fresh();
        });
    }

    private function generateBookingCode(): string
    {
        do {
            $code = 'BK-'.now()->format('ymd').'-'.strtoupper(Str::random(5));
        } while (Booking::query()->where('booking_code', $code)->exists());

        return $code;
    }
}
