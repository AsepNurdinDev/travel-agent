<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('blog_posts.view');
    }

    public function view(User $user, BlogPost $blogPost): bool
    {
        return $user->can('blog_posts.view');
    }

    public function create(User $user): bool
    {
        return $user->can('blog_posts.create');
    }

    public function update(User $user, BlogPost $blogPost): bool
    {
        return $user->can('blog_posts.update');
    }

    public function delete(User $user, BlogPost $blogPost): bool
    {
        return $user->can('blog_posts.delete');
    }

    public function restore(User $user, BlogPost $blogPost): bool
    {
        return $user->can('blog_posts.update');
    }

    public function forceDelete(User $user, BlogPost $blogPost): bool
    {
        return $user->can('blog_posts.delete') && $user->hasRole('super_admin');
    }
}
