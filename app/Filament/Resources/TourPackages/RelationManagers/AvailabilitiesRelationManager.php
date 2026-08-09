<?php

namespace App\Filament\Resources\TourPackages\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AvailabilitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'availabilities';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('departure_date')->required(),
            DatePicker::make('return_date')->required()->afterOrEqual('departure_date'),
            TextInput::make('quota')->numeric()->minValue(1)->required(),
            TextInput::make('seats_booked')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->disabled(fn (?\App\Models\TourPackageAvailability $record) => $record !== null)
                ->dehydrated(fn (?\App\Models\TourPackageAvailability $record) => $record === null)
                ->helperText('Managed automatically by the booking flow once bookings exist.'),
            TextInput::make('price_adult_override')->numeric()->prefix('Rp')->minValue(0)
                ->helperText('Leave empty to use the package base price.'),
            TextInput::make('price_child_override')->numeric()->prefix('Rp')->minValue(0),
            TextInput::make('price_infant_override')->numeric()->prefix('Rp')->minValue(0),
            Select::make('status')
                ->options([
                    'open' => 'Open',
                    'closed' => 'Closed',
                    'full' => 'Full',
                    'cancelled' => 'Cancelled',
                ])
                ->default('open')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('departure_date')
            ->columns([
                TextColumn::make('departure_date')->date()->sortable(),
                TextColumn::make('return_date')->date(),
                TextColumn::make('quota')->label('Quota'),
                TextColumn::make('seats_booked')->label('Booked'),
                TextColumn::make('remaining_quota')->label('Remaining')->state(fn ($record) => $record->remaining_quota),
                TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'open' => 'success',
                    'closed' => 'gray',
                    'full' => 'warning',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
            ])
            ->defaultSort('departure_date')
            ->filters([SelectFilter::make('status')->options([
                'open' => 'Open', 'closed' => 'Closed', 'full' => 'Full', 'cancelled' => 'Cancelled',
            ])])
            ->headerActions([CreateAction::make()])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
