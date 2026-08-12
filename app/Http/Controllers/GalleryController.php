<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $images = Gallery::query()
            ->with(['destination', 'tourPackage'])
            ->when($request->filled('destination'), fn ($q) => $q->where('destination_id', $request->integer('destination')))
            ->latest()
            ->paginate(16)
            ->withQueryString();

        $destinations = Destination::query()->active()->orderBy('name')->get(['id', 'name']);

        return view('gallery.index', compact('images', 'destinations'));
    }
}
