<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;

/**
 * Missing from the original scaffold: BlogCategoryResource existed with no
 * policy at all, which means Filament would authorize every action for any
 * authenticated panel user regardless of role. Added to close that gap.
 */
class BlogCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('blog_categories.view');
    }

    public function view(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('blog_categories.view');
    }

    public function create(User $user): bool
    {
        return $user->can('blog_categories.create');
    }

    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('blog_categories.update');
    }

    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('blog_categories.delete');
    }

    public function restore(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('blog_categories.update');
    }

    public function forceDelete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('blog_categories.delete') && $user->hasRole('super_admin');
    }
}
