<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = BlogCategory::factory()->count(4)->create();
        $author = User::query()->first();

        // Exactly 10 blog posts total, spread across the 4 categories.
        collect(range(1, 10))->each(function () use ($categories, $author) {
            BlogPost::factory()->create([
                'blog_category_id' => $categories->random()->id,
                'user_id' => $author?->id,
            ]);
        });
    }
}
