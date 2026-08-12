<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $customer = Auth::user()->customer;

        $myReviews = $customer
            ? Review::query()->where('customer_id', $customer->id)->with('tourPackage')->latest()->get()
            : collect();

        // Completed bookings that don't have a review yet.
        $reviewableBookings = $customer
            ? Booking::query()
                ->where('customer_id', $customer->id)
                ->where('status', 'completed')
                ->whereDoesntHave('review')
                ->with('tourPackage')
                ->get()
            : collect();

        return view('account.reviews', compact('myReviews', 'reviewableBookings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $customer = Auth::user()->customer;
        abort_unless($customer, 404);

        $data = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        $booking = Booking::query()->findOrFail($data['booking_id']);

        abort_if($booking->customer_id !== $customer->id, 403);
        abort_unless($booking->status === 'completed', 422, 'Only completed trips can be reviewed.');

        Review::query()->firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'customer_id' => $customer->id,
                'tour_package_id' => $booking->tour_package_id,
                'rating' => $data['rating'],
                'title' => $data['title'] ?? null,
                'comment' => $data['comment'],
                'is_approved' => false,
            ]
        );

        return back()->with('success', 'Thanks! Your review has been submitted and is awaiting approval.');
    }
}
