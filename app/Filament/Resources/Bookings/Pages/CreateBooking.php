<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Customer;
use App\Models\Promotion;
use App\Models\TourPackageAvailability;
use App\Services\Booking\BookingService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    /**
     * Deliberately bypasses the default "mass-create from form data" flow.
     * Pricing must always be recalculated server-side by BookingService —
     * nothing about total_amount/subtotal/discount is ever trusted from
     * the submitted form.
     */
    protected function handleRecordCreation(array $data): Model
    {
        $customer = Customer::query()->findOrFail($data['customer_id']);
        $availability = TourPackageAvailability::query()->findOrFail($data['tour_package_availability_id']);
        $promotion = ! empty($data['promotion_id']) ? Promotion::query()->find($data['promotion_id']) : null;

        $addons = collect($data['selected_addons'] ?? [])
            ->filter(fn ($line) => ! empty($line['addon_id']))
            ->map(fn ($line) => [
                'addon_id' => (int) $line['addon_id'],
                'quantity' => max(1, (int) ($line['quantity'] ?? 1)),
            ])
            ->values()
            ->all();

        return app(BookingService::class)->createBooking(
            customer: $customer,
            availability: $availability,
            adultCount: (int) ($data['adult_count'] ?? 0),
            childCount: (int) ($data['child_count'] ?? 0),
            infantCount: (int) ($data['infant_count'] ?? 0),
            addons: $addons,
            promotion: $promotion,
            notes: $data['notes'] ?? null,
            createdBy: auth()->id(),
        );
    }
}
