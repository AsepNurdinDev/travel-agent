<?php

namespace App\Filament\Widgets;

use App\Models\TourPackageAvailability;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingTrips extends TableWidget
{
    protected static ?string $heading = 'Upcoming Departures';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => TourPackageAvailability::query()
                ->where('departure_date', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->orderBy('departure_date')
                ->limit(10))
            ->columns([
                TextColumn::make('tourPackage.name')->label('Package'),
                TextColumn::make('departure_date')->date(),
                TextColumn::make('quota'),
                TextColumn::make('seats_booked')->label('Booked'),
                TextColumn::make('remaining_quota')->label('Remaining')->state(fn ($record) => $record->remaining_quota),
                TextColumn::make('status')->badge(),
            ])
            ->paginated(false);
    }
}
