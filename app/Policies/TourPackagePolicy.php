<?php

namespace App\Policies;

use App\Models\TourPackage;
use App\Models\User;

class TourPackagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('tour_packages.view');
    }

    public function view(User $user, TourPackage $tourPackage): bool
    {
        return $user->can('tour_packages.view');
    }

    public function create(User $user): bool
    {
        return $user->can('tour_packages.create');
    }

    public function update(User $user, TourPackage $tourPackage): bool
    {
        return $user->can('tour_packages.update');
    }

    public function delete(User $user, TourPackage $tourPackage): bool
    {
        return $user->can('tour_packages.delete');
    }

    public function restore(User $user, TourPackage $tourPackage): bool
    {
        return $user->can('tour_packages.update');
    }

    public function forceDelete(User $user, TourPackage $tourPackage): bool
    {
        return $user->can('tour_packages.delete') && $user->hasRole('super_admin');
    }
}
