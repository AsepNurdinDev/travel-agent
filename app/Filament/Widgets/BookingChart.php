<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class BookingChart extends ChartWidget
{
    protected ?string $heading = 'Tren Booking';

    protected ?string $description = '30 hari terakhir';

    protected static ?int $sort = -1;

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(fn ($i) => now()->subDays($i)->toDateString());

        $counts = Booking::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('total', 'day');

        return [
            'datasets' => [
                [
                    'label' => 'Booking',
                    'data' => $days->map(fn ($day) => $counts[$day] ?? 0)->all(),
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.15)',
                    'pointBackgroundColor' => '#0ea5e9',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $days->map(fn ($day) => \Illuminate\Support\Carbon::parse($day)->translatedFormat('d M'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
