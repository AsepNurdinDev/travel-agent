<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->searchable()
                ->required(),
            Select::make('tour_package_id')
                ->relationship('tourPackage', 'name')
                ->searchable()
                ->required(),
            Select::make('rating')
                ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                ->required(),
            TextInput::make('title')->maxLength(255),
            Textarea::make('comment')->required()->columnSpanFull(),
            Toggle::make('is_approved')->label('Approved (visible on public site)'),
        ]);
    }
}
