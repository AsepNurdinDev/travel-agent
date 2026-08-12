<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(Request $request): View
    {
        $destinations = Destination::query()
            ->active()
            ->withCount('tourPackages')
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('city', 'like', "%{$request->search}%")
                    ->orWhere('country', 'like', "%{$request->search}%");
            }))
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('destinations.index', compact('destinations'));
    }

    public function show(Destination $destination): View
    {
        abort_unless($destination->is_active, 404);

        $destination->load(['galleries' => fn ($q) => $q->latest()->take(8)]);

        $tours = $destination->tourPackages()
            ->active()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(6);

        return view('destinations.show', compact('destination', 'tours'));
    }
}
