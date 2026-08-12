<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Booking\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {
    }

    public function index(Request $request): View
    {
        $customer = Auth::user()->customer;

        $query = Booking::query()
            ->where('customer_id', $customer?->id ?? 0)
            ->with(['tourPackage.destination', 'availability', 'invoice']);

        $tab = $request->get('tab', 'all');

        match ($tab) {
            'upcoming' => $query->where('status', 'confirmed')
                ->whereHas('availability', fn ($q) => $q->where('departure_date', '>=', now()->toDateString())),
            'completed' => $query->where('status', 'completed'),
            'cancelled' => $query->where('status', 'cancelled'),
            default => null,
        };

        $bookings = $query->latest()->paginate(8)->withQueryString();

        return view('account.bookings', compact('bookings', 'tab'));
    }

    public function show(Booking $booking): View
    {
        $this->authorizeOwnership($booking);

        $booking->load(['tourPackage.destination', 'availability', 'items', 'payments', 'invoice', 'promotion']);

        return view('account.booking-detail', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorizeOwnership($booking);

        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return back()->with('error', 'This booking can no longer be cancelled.');
        }

        try {
            $this->bookingService->cancelBooking($booking);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Your booking has been cancelled.');
    }

    private function authorizeOwnership(Booking $booking): void
    {
        $customer = Auth::user()->customer;

        abort_if(! $customer || $booking->customer_id !== $customer->id, 403);
    }
}
