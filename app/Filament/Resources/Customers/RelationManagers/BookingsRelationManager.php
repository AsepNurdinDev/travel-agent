<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    /**
     * Read-only here by design: bookings must always be created through
     * BookingResource / BookingService (price recalculation, seat locking),
     * never mass-assigned from a plain relation manager form.
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('booking_code')
            ->columns([
                TextColumn::make('booking_code'),
                TextColumn::make('tourPackage.name')->label('Package'),
                TextColumn::make('total_amount')->money('IDR'),
                TextColumn::make('amount_paid')->money('IDR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
