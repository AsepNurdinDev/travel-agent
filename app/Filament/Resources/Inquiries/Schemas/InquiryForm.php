<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255)
                ->disabled(fn (?\App\Models\Inquiry $record) => $record !== null),
            TextInput::make('email')->email()->required()->maxLength(255)
                ->disabled(fn (?\App\Models\Inquiry $record) => $record !== null),
            TextInput::make('phone')->tel()->maxLength(50)
                ->disabled(fn (?\App\Models\Inquiry $record) => $record !== null),
            TextInput::make('subject')->maxLength(255)
                ->disabled(fn (?\App\Models\Inquiry $record) => $record !== null),
            Textarea::make('message')->required()->columnSpanFull()
                ->disabled(fn (?\App\Models\Inquiry $record) => $record !== null),
            Select::make('status')
                ->options(['new' => 'New', 'in_progress' => 'In Progress', 'closed' => 'Closed'])
                ->required(),
        ]);
    }
}
