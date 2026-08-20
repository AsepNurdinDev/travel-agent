<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Pendapatan Terkumpul';

    protected ?string $description = '6 bulan terakhir';

    protected static ?int $sort = -1;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

        $totals = Payment::query()
            ->where('status', 'paid')
            ->where('paid_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $months->map(fn ($m) => (float) ($totals[$m->format('Y-m')] ?? 0))->all(),
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                    'borderRadius' => 6,
                    'maxBarThickness' => 42,
                ],
            ],
            'labels' => $months->map(fn ($m) => $m->translatedFormat('M Y'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
