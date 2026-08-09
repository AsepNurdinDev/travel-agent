<?php

namespace App\Filament\Resources\Hotels\Schemas;

use App\Models\Destination;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HotelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            Select::make('destination_id')
                ->label('Destination')
                ->options(fn () => Destination::pluck('name', 'id'))
                ->searchable(),
            TextInput::make('star_rating')->numeric()->minValue(1)->maxValue(5),
            TextInput::make('phone')->tel()->maxLength(50),
            Textarea::make('address')->columnSpanFull(),
            Textarea::make('description')->columnSpanFull(),
            Toggle::make('is_active')->default(true),
        ]);
    }
}
