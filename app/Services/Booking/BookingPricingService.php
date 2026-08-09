<?php

namespace App\Services\Booking;

use App\Models\Promotion;
use App\Models\TourPackage;
use App\Models\TourPackageAddon;
use App\Models\TourPackageAvailability;
use InvalidArgumentException;

/**
 * Server-side price calculation for a booking.
 *
 * CRITICAL SECURITY BOUNDARY: this is the ONLY place a booking total may be
 * computed. Any total_amount that reaches the database must have come
 * through here — never trust a subtotal/total sent from the browser or an
 * admin form field for the amount itself.
 */
class BookingPricingService
{
    /**
     * @param  array<int, array{addon_id: int, quantity: int}>  $addons
     * @return array{
     *     price_adult: string, price_child: string, price_infant: string,
     *     addons_total: string, subtotal: string, discount_amount: string,
     *     total_amount: string, items: array<int, array{addon_id: int, name: string, unit_price: string, quantity: int, subtotal: string}>,
     * }
     */
    public function calculate(
        TourPackageAvailability $availability,
        int $adultCount,
        int $childCount,
        int $infantCount,
        array $addons = [],
        ?Promotion $promotion = null,
    ): array {
        if ($adultCount + $childCount + $infantCount < 1) {
            throw new InvalidArgumentException('A booking must have at least one participant.');
        }

        /** @var TourPackage $package */
        $package = $availability->tourPackage;

        $priceAdult = $availability->price_adult_override ?? $package->price_adult;
        $priceChild = $availability->price_child_override ?? $package->price_child;
        $priceInfant = $availability->price_infant_override ?? $package->price_infant;

        $participantsTotal = bcadd(
            bcadd(
                bcmul((string) $priceAdult, (string) $adultCount, 2),
                bcmul((string) $priceChild, (string) $childCount, 2),
                2
            ),
            bcmul((string) $priceInfant, (string) $infantCount, 2),
            2
        );

        $addonItems = [];
        $addonsTotal = '0.00';

        if (! empty($addons)) {
            $addonModels = TourPackageAddon::query()
                ->whereIn('id', array_column($addons, 'addon_id'))
                ->where('tour_package_id', $package->id)
                ->where('is_active', true)
                ->get()
                ->keyBy('id');

            foreach ($addons as $line) {
                $addon = $addonModels->get($line['addon_id']);

                if (! $addon) {
                    // Addon doesn't belong to this package / isn't active — ignore silently
                    // rather than trusting a client-supplied price for it.
                    continue;
                }

                $quantity = max(1, (int) $line['quantity']);
                $lineSubtotal = bcmul((string) $addon->price, (string) $quantity, 2);

                $addonItems[] = [
                    'addon_id' => $addon->id,
                    'name' => $addon->name,
                    'unit_price' => (string) $addon->price,
                    'quantity' => $quantity,
                    'subtotal' => $lineSubtotal,
                ];

                $addonsTotal = bcadd($addonsTotal, $lineSubtotal, 2);
            }
        }

        $subtotal = bcadd($participantsTotal, $addonsTotal, 2);
        $discount = $this->calculateDiscount($subtotal, $promotion);
        $total = bcsub($subtotal, $discount, 2);

        return [
            'price_adult' => (string) $priceAdult,
            'price_child' => (string) $priceChild,
            'price_infant' => (string) $priceInfant,
            'addons_total' => $addonsTotal,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'total_amount' => $total,
            'items' => $addonItems,
        ];
    }

    private function calculateDiscount(string $subtotal, ?Promotion $promotion): string
    {
        if (! $promotion || ! $promotion->isCurrentlyValid()) {
            return '0.00';
        }

        if ($promotion->min_purchase && bccomp($subtotal, (string) $promotion->min_purchase, 2) < 0) {
            return '0.00';
        }

        if ($promotion->type === 'fixed') {
            $discount = (string) $promotion->value;
        } else {
            $discount = bcdiv(bcmul($subtotal, (string) $promotion->value, 4), '100', 2);

            if ($promotion->max_discount !== null && bccomp($discount, (string) $promotion->max_discount, 2) > 0) {
                $discount = (string) $promotion->max_discount;
            }
        }

        // Never let a discount exceed the subtotal it's applied to.
        if (bccomp($discount, $subtotal, 2) > 0) {
            $discount = $subtotal;
        }

        return $discount;
    }
}
