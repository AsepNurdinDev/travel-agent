<?php

namespace App\Services\Booking;

use App\Models\TourPackageAvailability;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Owns all seat/quota mutations for a departure. Booking and cancellation
 * flows must go through here so seats_booked can never drift out of sync
 * with actual confirmed bookings, and two concurrent bookings can't both
 * grab the last seat.
 */
class BookingAvailabilityService
{
    public function reserveSeats(TourPackageAvailability $availability, int $participantCount): TourPackageAvailability
    {
        return DB::transaction(function () use ($availability, $participantCount) {
            /** @var TourPackageAvailability $locked */
            $locked = TourPackageAvailability::query()
                ->whereKey($availability->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== 'open') {
                throw new RuntimeException('This departure is not open for booking.');
            }

            if ($locked->remaining_quota < $participantCount) {
                throw new RuntimeException('Not enough seats available for this departure.');
            }

            $locked->seats_booked += $participantCount;

            if ($locked->seats_booked >= $locked->quota) {
                $locked->status = 'full';
            }

            $locked->save();

            return $locked;
        });
    }

    public function releaseSeats(TourPackageAvailability $availability, int $participantCount): TourPackageAvailability
    {
        return DB::transaction(function () use ($availability, $participantCount) {
            /** @var TourPackageAvailability $locked */
            $locked = TourPackageAvailability::query()
                ->whereKey($availability->id)
                ->lockForUpdate()
                ->firstOrFail();

            $locked->seats_booked = max(0, $locked->seats_booked - $participantCount);

            if ($locked->status === 'full' && $locked->seats_booked < $locked->quota) {
                $locked->status = 'open';
            }

            $locked->save();

            return $locked;
        });
    }
}
