<?php

namespace App\Filament\Resources\TourPackages\Schemas;

use App\Models\Destination;
use App\Services\Tour\TourPackageService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TourPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Package Details')
                    ->columns(2)
                    ->components([
                        Select::make('destination_id')
                            ->label('Destination')
                            ->options(fn () => Destination::query()->active()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, callable $set, ?string $old, $record) {
                                if ($record) {
                                    return; // don't silently change the slug/URL of an existing package
                                }
                                $set('slug', app(TourPackageService::class)->generateUniqueSlug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Used in the public package URL.'),
                        TextInput::make('duration_days')
                            ->label('Duration (days)')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        TextInput::make('duration_nights')
                            ->label('Duration (nights)')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('min_participants')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                        TextInput::make('max_participants')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Leave empty for no limit.'),
                        FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('tour-packages')
                            ->maxSize(3072)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pricing (per person, IDR)')
                    ->description('This is the base price used whenever a departure does not override it.')
                    ->columns(3)
                    ->components([
                        TextInput::make('price_adult')
                            ->label('Adult price')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required(),
                        TextInput::make('price_child')
                            ->label('Child price')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required(),
                        TextInput::make('price_infant')
                            ->label('Infant price')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                    ]),

                Section::make('Visibility & SEO')
                    ->columns(2)
                    ->components([
                        Toggle::make('is_active')
                            ->label('Active (visible on the public site)')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Featured'),
                        TextInput::make('meta_title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('meta_description')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
