<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BookingChart;
use App\Filament\Widgets\RecentBookings;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\UpcomingTrips;
use App\Filament\Widgets\WelcomeBanner;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    // Mengubah ikon navigasi sidebar agar selaras dengan tema aplikasi
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Ringkasan Bisnis';

    public function getTitle(): string
    {
        return 'Selamat Datang Kembali 👋';
    }

    public function getSubheading(): ?string
    {
        return 'Pantau performa pemesanan, pendapatan, dan perjalanan hari ini.';
    }

    // Menambahkan tombol aksi cepat di bagian atas Dashboard
    protected function getHeaderActions(): array
    {
        return [
            Action::make('buat_pemesanan')
                ->label('+ Pemesanan Baru')
                ->color('primary')
                ->url(fn (): string => route('filament.admin.resources.bookings.create')),
        ];
    }

    public function getWidgets(): array
    {
        return [
            WelcomeBanner::class,
            StatsOverview::class,
            BookingChart::class,
            RevenueChart::class,
            RecentBookings::class,
            UpcomingTrips::class,
        ];
    }

    // Mengatur responsivitas grid widget agar lebih leluasa di layar lebar
    public function getColumns(): int|array
    {
        return [
            'default' => 1,

'md' => 2,
'xl' => 2,
        ];
    }
}