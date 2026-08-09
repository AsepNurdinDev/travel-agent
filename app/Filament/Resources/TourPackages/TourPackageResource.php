<?php

namespace App\Filament\Resources\TourPackages;

use UnitEnum;
use App\Filament\Resources\TourPackages\Pages\CreateTourPackage;
use App\Filament\Resources\TourPackages\Pages\EditTourPackage;
use App\Filament\Resources\TourPackages\Pages\ListTourPackages;
use App\Filament\Resources\TourPackages\RelationManagers\AddonsRelationManager;
use App\Filament\Resources\TourPackages\RelationManagers\AvailabilitiesRelationManager;
use App\Filament\Resources\TourPackages\RelationManagers\ExclusionsRelationManager;
use App\Filament\Resources\TourPackages\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\TourPackages\RelationManagers\InclusionsRelationManager;
use App\Filament\Resources\TourPackages\RelationManagers\ItinerariesRelationManager;
use App\Filament\Resources\TourPackages\Schemas\TourPackageForm;
use App\Filament\Resources\TourPackages\Tables\TourPackagesTable;
use App\Models\TourPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TourPackageResource extends Resource
{
    protected static ?string $model = TourPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TourPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TourPackagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            ItinerariesRelationManager::class,
            InclusionsRelationManager::class,
            ExclusionsRelationManager::class,
            AddonsRelationManager::class,
            AvailabilitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTourPackages::route('/'),
            'create' => CreateTourPackage::route('/create'),
            'edit' => EditTourPackage::route('/{record}/edit'),
        ];
    }
}
