<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\TourPackage;
use Filament\Widgets\Widget;

class StatsOverview extends Widget
{
    protected string $view = 'filament.widgets.stats-overview';

    protected static ?int $sort = -2;

    protected int|string|array $columnSpan = 'full';

    /**
     * Data statistik untuk kartu dashboard.
     * Query & logika perhitungan TIDAK diubah dari versi sebelumnya,
     * hanya disusun ulang agar bisa dirender dengan tampilan kustom.
     */
    public function getStats(): array
    {
        $revenueThisMonth = Booking::query()
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount_paid');

        $bookingsThisMonth = Booking::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $activePackages = TourPackage::query()->active()->count();

        $totalCustomers = Customer::query()->count();

        return [
            [
                'label' => 'Booking Bulan Ini',
                'value' => number_format($bookingsThisMonth, 0, ',', '.'),
                'icon' => 'heroicon-o-calendar-days',
                'color' => 'sky',
                'description' => 'Total transaksi booking bulan berjalan',
            ],
            [
                'label' => 'Pendapatan Bulan Ini',
                'value' => 'Rp '.number_format((float) $revenueThisMonth, 0, ',', '.'),
                'icon' => 'heroicon-o-banknotes',
                'color' => 'emerald',
                'description' => 'Dana yang sudah diterima dari pelanggan',
            ],
            [
                'label' => 'Paket Wisata Aktif',
                'value' => number_format($activePackages, 0, ',', '.'),
                'icon' => 'heroicon-o-map',
                'color' => 'amber',
                'description' => 'Paket yang saat ini dipasarkan',
            ],
            [
                'label' => 'Total Pelanggan',
                'value' => number_format($totalCustomers, 0, ',', '.'),
                'icon' => 'heroicon-o-users',
                'color' => 'rose',
                'description' => 'Pelanggan terdaftar di sistem',
            ],
        ];
    }
}
