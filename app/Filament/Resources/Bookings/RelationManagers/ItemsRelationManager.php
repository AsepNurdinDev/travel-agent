<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    /**
     * Read-only: line items are a priced snapshot created by
     * BookingPricingService at booking time, never hand-edited afterwards.
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('unit_price')->money('IDR'),
                TextColumn::make('quantity'),
                TextColumn::make('subtotal')->money('IDR'),
            ]);
    }
}
