<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('type')->required()->maxLength(255),
            TextInput::make('capacity')->numeric()->minValue(1)->required(),
            TextInput::make('price_per_day')->numeric()->prefix('Rp')->minValue(0)->required(),
            Textarea::make('description')->columnSpanFull(),
            Toggle::make('is_active')->default(true),
        ]);
    }
}
