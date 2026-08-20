<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Filament\Resources\Customers\RelationManagers\BookingsRelationManager;
use App\Filament\Resources\Customers\RelationManagers\ReviewsRelationManager;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    // Mengubah icon ke ikon pengguna/pelanggan (Heroicon UserGroup atau Users)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    // Disarankan masuk ke grup 'User Management' atau bisa tetap 'Transactions' jika lebih suka disatukan
    protected static string|UnitEnum|null $navigationGroup = 'User Management';

    // Mengubah label menu di sidebar ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Pelanggan';

    // Urutan posisi menu di dalam grupnya
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BookingsRelationManager::class,
            ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}