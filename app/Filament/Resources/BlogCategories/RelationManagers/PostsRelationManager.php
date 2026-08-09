<?php

namespace App\Filament\Resources\BlogCategories\RelationManagers;

use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('author.name'),
                IconColumn::make('is_published')->boolean(),
                TextColumn::make('published_at')->dateTime(),
            ])
            ->recordActions([EditAction::make()]);
    }
}
