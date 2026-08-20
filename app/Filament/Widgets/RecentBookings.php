<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentBookings extends TableWidget
{
    protected static ?string $heading = 'Booking Terbaru';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Booking::query()->latest()->limit(10))
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->weight('bold')
                    ->color('primary'),
                TextColumn::make('customer.name')
                    ->label('Pelanggan'),
                TextColumn::make('tourPackage.name')
                    ->label('Paket Wisata')
                    ->wrap(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->since(),
            ])
            ->paginated(false);
    }
}
