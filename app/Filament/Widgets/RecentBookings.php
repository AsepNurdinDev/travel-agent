<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentBookings extends TableWidget
{
    protected static ?string $heading = 'Recent Bookings';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Booking::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('booking_code'),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('tourPackage.name')->label('Package'),
                TextColumn::make('total_amount')->money('IDR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime()->since(),
            ])
            ->paginated(false);
    }
}
