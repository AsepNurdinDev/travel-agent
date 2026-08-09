<?php

namespace App\Filament\Resources\Galleries\Schemas;

use App\Models\Destination;
use App\Models\TourPackage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->maxLength(255),
            Select::make('tour_package_id')
                ->label('Tour Package')
                ->options(fn () => TourPackage::pluck('name', 'id'))
                ->searchable(),
            Select::make('destination_id')
                ->label('Destination')
                ->options(fn () => Destination::pluck('name', 'id'))
                ->searchable(),
            FileUpload::make('image')->image()->directory('gallery')->required(),
            TextInput::make('caption')->maxLength(255),
        ]);
    }
}
