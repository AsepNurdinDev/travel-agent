<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourPackageController extends Controller
{
    public function index(Request $request): View
    {
        $tours = TourPackage::query()
            ->active()
            ->with('destination')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->filled('destination'), fn ($q) => $q->where('destination_id', $request->integer('destination')))
            ->when($request->filled('duration'), function ($q) use ($request) {
                match ($request->duration) {
                    'short' => $q->where('duration_days', '<=', 3),
                    'medium' => $q->whereBetween('duration_days', [4, 7]),
                    'long' => $q->where('duration_days', '>=', 8),
                    default => null,
                };
            })
            ->when($request->filled('price_max'), fn ($q) => $q->where('price_adult', '<=', $request->float('price_max')))
            ->when($request->filled('rating'), fn ($q) => $q->having('reviews_avg_rating', '>=', $request->float('rating')))
            ->when($request->get('sort'), function ($q, $sort) {
                match ($sort) {
                    'price_asc' => $q->orderBy('price_adult'),
                    'price_desc' => $q->orderByDesc('price_adult'),
                    'rating' => $q->orderByDesc('reviews_avg_rating'),
                    'duration' => $q->orderBy('duration_days'),
                    default => $q->orderByDesc('is_featured')->orderByDesc('created_at'),
                };
            }, fn ($q) => $q->orderByDesc('is_featured')->orderByDesc('created_at'))
            ->paginate(9)
            ->withQueryString();

        $destinations = Destination::query()->active()->orderBy('name')->get(['id', 'name']);

        return view('tours.index', compact('tours', 'destinations'));
    }

    public function show(TourPackage $tourPackage): View
    {
        abort_unless($tourPackage->is_active, 404);

        $tourPackage->load([
            'destination',
            'images',
            'itineraries',
            'inclusions',
            'exclusions',
            'addons' => fn ($q) => $q->where('is_active', true),
            'availabilities' => fn ($q) => $q->where('departure_date', '>=', now()->toDateString())->orderBy('departure_date'),
            'reviews' => fn ($q) => $q->approved()->with('customer')->latest()->take(10),
        ]);

        $tourPackage->loadCount('reviews')->loadAvg('reviews', 'rating');

        $relatedTours = TourPackage::query()
            ->active()
            ->where('destination_id', $tourPackage->destination_id)
            ->whereKeyNot($tourPackage->id)
            ->withAvg('reviews', 'rating')
            ->take(4)
            ->get();

        return view('tours.show', compact('tourPackage', 'relatedTours'));
    }
}
