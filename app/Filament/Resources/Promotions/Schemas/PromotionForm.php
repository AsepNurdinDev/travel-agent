<?php

namespace App\Filament\Resources\Promotions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50)
                ->formatStateUsing(fn (?string $state) => $state ? strtoupper($state) : $state)
                ->dehydrateStateUsing(fn (?string $state) => strtoupper((string) $state)),
            TextInput::make('name')->required()->maxLength(255),
            Select::make('type')
                ->options(['percentage' => 'Percentage', 'fixed' => 'Fixed amount'])
                ->required()
                ->live()
                ->default('percentage'),
            TextInput::make('value')
                ->numeric()
                ->minValue(0)
                ->required()
                ->suffix(fn (callable $get) => $get('type') === 'percentage' ? '%' : 'Rp')
                ->maxValue(fn (callable $get) => $get('type') === 'percentage' ? 100 : null),
            TextInput::make('max_discount')
                ->numeric()
                ->prefix('Rp')
                ->visible(fn (callable $get) => $get('type') === 'percentage')
                ->helperText('Optional cap on the discount amount.'),
            TextInput::make('min_purchase')->numeric()->prefix('Rp')->minValue(0),
            DateTimePicker::make('starts_at'),
            DateTimePicker::make('ends_at')->afterOrEqual('starts_at'),
            TextInput::make('usage_limit')->numeric()->minValue(1)->helperText('Leave empty for unlimited uses.'),
            Toggle::make('is_active')->default(true),
            Textarea::make('description')->columnSpanFull(),
        ]);
    }
}
