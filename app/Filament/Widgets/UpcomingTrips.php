<?php

namespace App\Filament\Widgets;

use App\Models\TourPackageAvailability;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingTrips extends TableWidget
{
    protected static ?string $heading = 'Keberangkatan Mendatang';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => TourPackageAvailability::query()
                ->where('departure_date', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->orderBy('departure_date')
                ->limit(10))
            ->columns([
                TextColumn::make('tourPackage.name')
                    ->label('Paket Wisata')
                    ->weight('bold')
                    ->wrap(),
                TextColumn::make('departure_date')
                    ->label('Tanggal Berangkat')
                    ->date('d M Y'),
                TextColumn::make('quota')
                    ->label('Kuota'),
                TextColumn::make('seats_booked')
                    ->label('Terisi'),
                TextColumn::make('remaining_quota')
                    ->label('Sisa Kuota')
                    ->state(fn ($record) => $record->remaining_quota)
                    ->badge()
                    ->color(fn ($state): string => $state > 0 ? 'success' : 'danger'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'Terbuka',
                        'full' => 'Penuh',
                        'closed' => 'Ditutup',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'full' => 'warning',
                        'closed', 'cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}
