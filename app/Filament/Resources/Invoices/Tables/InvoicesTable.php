<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')->searchable(),
                TextColumn::make('booking.booking_code')->label('Booking')->searchable(),
                TextColumn::make('booking.customer.name')->label('Customer')->searchable(),
                TextColumn::make('amount')->money('IDR')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'paid' => 'success',
                        'partially_paid' => 'warning',
                        'unpaid' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('issued_date')->date()->sortable(),
                TextColumn::make('due_date')->date(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'unpaid' => 'Unpaid', 'partially_paid' => 'Partially Paid', 'paid' => 'Paid', 'cancelled' => 'Cancelled',
                ]),
            ])
            ->searchable()
            ->defaultSort('issued_date', 'desc')
            ->recordActions([EditAction::make()]);
    }
}
