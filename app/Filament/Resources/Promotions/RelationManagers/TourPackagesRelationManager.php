<?php

namespace App\Filament\Resources\Promotions\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Many-to-many: attach/detach existing tour packages to this promotion.
 * No create/edit/delete here — those would mutate the TourPackage record
 * itself, which belongs to TourPackageResource, not this pivot screen.
 */
class TourPackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'tourPackages';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('destination.name')->label('Destination'),
                TextColumn::make('price_adult')->money('IDR'),
            ])
            ->headerActions([
                AssociateAction::make(),
            ])
            ->recordActions([
                DissociateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                ]),
            ]);
    }
}
