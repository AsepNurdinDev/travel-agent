<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $customer = Auth::user()->customer;

        if (! $customer) {
            return view('account.dashboard', [
                'customer' => null,
                'stats' => ['total' => 0, 'upcoming' => 0, 'completed' => 0, 'pending_payment' => 0],
                'upcomingBooking' => null,
                'recentBookings' => collect(),
            ]);
        }

        $bookings = $customer->bookings()->with(['tourPackage.destination', 'availability'])->get();

        $stats = [
            'total' => $bookings->count(),
            'upcoming' => $bookings->filter(fn ($b) => $b->status === 'confirmed' && optional($b->availability)->departure_date?->isFuture())->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
            'pending_payment' => $bookings->filter(fn ($b) => (float) $b->balance_due > 0 && ! in_array($b->status, ['cancelled'], true))->count(),
        ];

        $upcomingBooking = $bookings
            ->filter(fn ($b) => in_array($b->status, ['confirmed', 'pending'], true) && optional($b->availability)->departure_date?->isFuture())
            ->sortBy(fn ($b) => $b->availability->departure_date)
            ->first();

        $recentBookings = $customer->bookings()
            ->with(['tourPackage.destination', 'availability'])
            ->latest()
            ->take(5)
            ->get();

        return view('account.dashboard', compact('customer', 'stats', 'upcomingBooking', 'recentBookings'));
    }
}
