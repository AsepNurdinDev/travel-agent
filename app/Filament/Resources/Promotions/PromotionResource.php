<?php

namespace App\Filament\Resources\Promotions;

use App\Filament\Resources\Promotions\Pages\CreatePromotion;
use App\Filament\Resources\Promotions\Pages\EditPromotion;
use App\Filament\Resources\Promotions\Pages\ListPromotions;
use App\Filament\Resources\Promotions\RelationManagers\TourPackagesRelationManager;
use App\Filament\Resources\Promotions\Schemas\PromotionForm;
use App\Filament\Resources\Promotions\Tables\PromotionsTable;
use App\Models\Promotion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    // Mengubah icon ke ikon diskon/promosi (Heroicon Ticket)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    // Tetap menggunakan grup 'Master Data'
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    // Mengubah label menu di sidebar ke Bahasa Indonesia
    protected static ?string $navigationLabel = 'Promosi & Diskon';

    // Urutan posisi menu di dalam grup Master Data (berada di bawah Paket Wisata)
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PromotionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromotionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TourPackagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromotions::route('/'),
            'create' => CreatePromotion::route('/create'),
            'edit' => EditPromotion::route('/{record}/edit'),
        ];
    }
}