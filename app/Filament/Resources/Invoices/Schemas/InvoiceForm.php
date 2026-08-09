<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

/**
 * Only due_date and notes are editable. invoice_number, amount and status
 * are system-managed (amount mirrors the booking total; status is derived
 * from payments by InvoiceService::syncStatusFromBooking()).
 */
class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Placeholder::make('invoice_number')
                ->content(fn ($record) => $record?->invoice_number),
            Placeholder::make('amount_display')
                ->label('Amount')
                ->content(fn ($record) => $record ? 'Rp '.number_format((float) $record->amount, 0, ',', '.') : '-'),
            Placeholder::make('status_display')
                ->label('Status')
                ->content(fn ($record) => $record?->status),
            DatePicker::make('due_date'),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }
}
