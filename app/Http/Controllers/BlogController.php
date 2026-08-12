<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = BlogPost::query()
            ->published()
            ->with(['category', 'author'])
            ->when($request->filled('category'), fn ($q) => $q->where('blog_category_id', $request->integer('category')))
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $featuredPost = BlogPost::query()->published()->with('category')->latest('published_at')->first();
        $categories = BlogCategory::query()->withCount('posts')->orderBy('name')->get();

        return view('blog.index', compact('posts', 'featuredPost', 'categories'));
    }

    public function show(BlogPost $blogPost): View
    {
        abort_unless($blogPost->is_published, 404);

        $blogPost->load(['category', 'author']);

        $relatedPosts = BlogPost::query()
            ->published()
            ->where('blog_category_id', $blogPost->blog_category_id)
            ->whereKeyNot($blogPost->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('blogPost', 'relatedPosts'));
    }
}
