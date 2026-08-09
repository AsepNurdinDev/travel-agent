<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use Filament\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('tourPackage.name')->label('Package'),
                TextColumn::make('rating')->badge(),
                TextColumn::make('title'),
                IconColumn::make('is_approved')->boolean(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->recordActions([DeleteAction::make()]);
    }
}
