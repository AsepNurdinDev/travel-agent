<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('bookings.view');
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->can('bookings.view');
    }

    public function create(User $user): bool
    {
        return $user->can('bookings.create');
    }

    public function update(User $user, Booking $booking): bool
    {
        // A cancelled or completed booking is a closed record; nobody
        // edits it further except super_admin (handled by Gate::before).
        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return false;
        }

        return $user->can('bookings.update');
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->can('bookings.delete');
    }

    public function restore(User $user, Booking $booking): bool
    {
        return $user->can('bookings.update');
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return $user->hasRole('super_admin');
    }
}
