<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\TourPackage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
{
    $featuredDestinations = Destination::query()
        ->active()
        ->withCount('tourPackages')
        ->orderByDesc('tour_packages_count')
        ->take(6)
        ->get();

    // Ganti $popularTours menjadi $popularPaketWisata
    $popularPaketWisata = TourPackage::query()
        ->active()
        ->with('destination')
        ->withCount('reviews')
        ->withAvg('reviews', 'rating')
        ->withCount('bookings')
        ->orderByDesc('bookings_count')
        ->take(8)
        ->get();

    $testimonials = Review::query()
        ->approved()
        ->with(['customer', 'tourPackage'])
        ->latest()
        ->take(6)
        ->get();

    $galleryPreview = Gallery::query()->latest()->take(8)->get();

    $latestPosts = BlogPost::query()
        ->published()
        ->with('category')
        ->latest('published_at')
        ->take(3)
        ->get();

    return view('home.index', compact(
        'featuredDestinations',
        'popularPaketWisata', // Sesuaikan di sini
        'testimonials',
        'galleryPreview',
        'latestPosts',
    ));
}
}
