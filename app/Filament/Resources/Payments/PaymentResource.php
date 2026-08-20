<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages\ListPayments;
use App\Filament\Resources\Payments\Tables\PaymentsTable;
use App\Models\Payment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/**
 * Intentionally list-only. Payments are sensitive financial records that
 * must only ever be created/mutated through PaymentService, invoked from
 * the "Record payment" / "Refund" actions on a Booking's payments relation
 * manager — never a free-form create/edit page here (see PaymentPolicy).
 */
class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    // Mengubah icon ke ikon Kartu Kredit/Pembayaran (Heroicon CreditCard)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    // Tetap menggunakan grup 'Transactions'
    protected static string|UnitEnum|null $navigationGroup = 'Transactions';

    // Mengubah label menu di sidebar ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Pembayaran';

    // Urutan posisi menu di dalam grup Transactions (berada di bawah Pemesanan)
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'payment_code';

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPayments::route('/'),
        ];
    }
}