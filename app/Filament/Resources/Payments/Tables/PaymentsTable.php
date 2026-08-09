<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_code')->searchable(),
                TextColumn::make('booking.booking_code')->label('Booking')->searchable(),
                TextColumn::make('booking.customer.name')->label('Customer')->searchable(),
                TextColumn::make('amount')->money('IDR')->sortable(),
                TextColumn::make('method')->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')->dateTime()->sortable(),
                TextColumn::make('verifiedBy.name')->label('Verified by'),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded',
                ]),
                SelectFilter::make('method')->options([
                    'bank_transfer' => 'Bank Transfer', 'credit_card' => 'Credit Card',
                    'e_wallet' => 'E-Wallet', 'cash' => 'Cash', 'other' => 'Other',
                ]),
            ])
            ->searchable()
            ->defaultSort('paid_at', 'desc');
    }
}
