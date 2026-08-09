<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\TourPackage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $revenueThisMonth = Booking::query()
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount_paid');

        return [
            Stat::make('Bookings this month', Booking::query()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count())
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Revenue collected this month', 'Rp '.number_format((float) $revenueThisMonth, 0, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Active tour packages', TourPackage::query()->active()->count())
                ->icon('heroicon-o-map'),

            Stat::make('Total customers', Customer::query()->count())
                ->icon('heroicon-o-users'),
        ];
    }
}
