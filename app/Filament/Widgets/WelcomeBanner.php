<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeBanner extends Widget
{
    protected string $view = 'filament.widgets.welcome-banner';

    protected static ?int $sort = -3;

    protected int|string|array $columnSpan = 'full';

    public function getGreeting(): string
    {
        $hour = (int) now()->format('H');

        return match (true) {
            $hour < 10 => 'Selamat pagi',
            $hour < 15 => 'Selamat siang',
            $hour < 18 => 'Selamat sore',
            default => 'Selamat malam',
        };
    }

    public function getUserName(): string
    {
        return auth()->user()?->name ?? 'Admin';
    }

    public function getTodayLabel(): string
    {
        return now()->locale('id')->translatedFormat('l, d F Y');
    }
}
