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

        $categories->each(function (BlogCategory $category) use ($author) {
            BlogPost::factory()
                ->count(random_int(2, 4))
                ->create([
                    'blog_category_id' => $category->id,
                    'user_id' => $author?->id,
                ]);
        });
    }
}
