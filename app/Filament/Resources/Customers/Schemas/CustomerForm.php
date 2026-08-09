<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make('phone')->tel()->required()->maxLength(50),
            TextInput::make('identity_number')->label('ID / Passport number')->maxLength(50),
            DatePicker::make('date_of_birth'),
            Textarea::make('address')->columnSpanFull(),
        ]);
    }
}
