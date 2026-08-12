<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Review;
use App\Models\TourPackage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $stats = [
            'destinations' => Destination::query()->active()->count(),
            'tours' => TourPackage::query()->active()->count(),
            'travelers' => Booking::query()->whereIn('status', ['confirmed', 'completed'])->count(),
            'avg_rating' => round((float) Review::query()->approved()->avg('rating'), 1),
        ];

        return view('about', compact('stats'));
    }
}
