<?php

namespace App\Filament\Resources\Invoices;

use App\Filament\Resources\Invoices\Pages\EditInvoice;
use App\Filament\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Resources\Invoices\Schemas\InvoiceForm;
use App\Filament\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    // Mengubah icon ke ikon Tagihan/Kuitansi (Heroicon DocumentCheck atau ReceiptPercent)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    // Tetap menggunakan grup 'Transactions'
    protected static string|UnitEnum|null $navigationGroup = 'Transactions';

    // Mengubah label menu di sidebar ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Faktur & Invois';

    // Urutan posisi menu di dalam grup Transactions (di bawah Pembayaran)
    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'invoice_number';

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Invoices are generated automatically by BookingService — no manual create page.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'edit' => EditInvoice::route('/{record}/edit'),
        ];
    }
}