<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;

class PromotionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('promotions.view');
    }

    public function view(User $user, Promotion $promotion): bool
    {
        return $user->can('promotions.view');
    }

    public function create(User $user): bool
    {
        return $user->can('promotions.create');
    }

    public function update(User $user, Promotion $promotion): bool
    {
        return $user->can('promotions.update');
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        return $user->can('promotions.delete');
    }

    public function restore(User $user, Promotion $promotion): bool
    {
        return $user->can('promotions.update');
    }

    public function forceDelete(User $user, Promotion $promotion): bool
    {
        return $user->can('promotions.delete') && $user->hasRole('super_admin');
    }
}
