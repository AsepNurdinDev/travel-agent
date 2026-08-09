<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Customer;
use App\Models\Promotion;
use App\Models\TourPackage;
use App\Models\TourPackageAddon;
use App\Models\TourPackageAvailability;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * IMPORTANT: this form never binds directly to price_*, subtotal,
 * discount_amount, total_amount or amount_paid. Those columns are only
 * ever written by BookingPricingService inside BookingService, invoked
 * from CreateBooking::handleRecordCreation(). The form only collects the
 * *intent* (who, which departure, how many people, which addons, which
 * promo code) — never a total.
 */
class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Booking')
                ->columns(2)
                ->components([
                    Select::make('customer_id')
                        ->label('Customer')
                        ->options(fn () => Customer::query()->limit(200)->get()->mapWithKeys(
                            fn (Customer $c) => [$c->id => "{$c->name} ({$c->email})"]
                        ))
                        ->searchable()
                        ->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null),

                    Select::make('tour_package_id')
                        ->label('Tour Package')
                        ->options(fn () => TourPackage::query()->active()->pluck('name', 'id'))
                        ->searchable()
                        ->live()
                        ->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null)
                        ->dehydrated(false)
                        ->afterStateUpdated(fn (callable $set) => $set('tour_package_availability_id', null)),

                    Select::make('tour_package_availability_id')
                        ->label('Departure')
                        ->options(function (callable $get) {
                            $packageId = $get('tour_package_id');

                            if (! $packageId) {
                                return [];
                            }

                            return TourPackageAvailability::query()
                                ->where('tour_package_id', $packageId)
                                ->where('status', 'open')
                                ->orderBy('departure_date')
                                ->get()
                                ->mapWithKeys(fn (TourPackageAvailability $a) => [
                                    $a->id => $a->departure_date->format('d M Y')." ({$a->remaining_quota} seats left)",
                                ]);
                        })
                        ->searchable()
                        ->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null)
                        ->columnSpanFull(),

                    TextInput::make('adult_count')
                        ->numeric()->minValue(0)->default(1)->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null),
                    TextInput::make('child_count')
                        ->numeric()->minValue(0)->default(0)->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null),
                    TextInput::make('infant_count')
                        ->numeric()->minValue(0)->default(0)->required()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null),

                    Select::make('promotion_id')
                        ->label('Promo code')
                        ->options(fn () => Promotion::query()->where('is_active', true)->pluck('code', 'id'))
                        ->searchable()
                        ->disabled(fn (?\App\Models\Booking $record) => $record !== null),
                ]),

            Section::make('Add-ons')
                ->visible(fn (?\App\Models\Booking $record) => $record === null)
                ->components([
                    Repeater::make('selected_addons')
                        ->label('')
                        ->dehydrated(true)
                        ->schema([
                            Select::make('addon_id')
                                ->label('Add-on')
                                ->options(function (callable $get, $livewire) {
                                    $packageId = $livewire->data['tour_package_id'] ?? null;

                                    if (! $packageId) {
                                        return [];
                                    }

                                    return TourPackageAddon::query()
                                        ->where('tour_package_id', $packageId)
                                        ->where('is_active', true)
                                        ->pluck('name', 'id');
                                })
                                ->required(),
                            TextInput::make('quantity')->numeric()->minValue(1)->default(1)->required(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add an add-on'),
                ]),

            Section::make('Status & pricing (read-only)')
                ->visible(fn (?\App\Models\Booking $record) => $record !== null)
                ->columns(2)
                ->components([
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'completed' => 'Completed',
                        ])
                        ->required(),
                    Placeholder::make('total_amount_display')
                        ->label('Total amount')
                        ->content(fn (?\App\Models\Booking $record) => $record ? 'Rp '.number_format((float) $record->total_amount, 0, ',', '.') : '-'),
                    Placeholder::make('amount_paid_display')
                        ->label('Amount paid')
                        ->content(fn (?\App\Models\Booking $record) => $record ? 'Rp '.number_format((float) $record->amount_paid, 0, ',', '.') : '-'),
                    Placeholder::make('balance_due_display')
                        ->label('Balance due')
                        ->content(fn (?\App\Models\Booking $record) => $record ? 'Rp '.number_format((float) $record->balance_due, 0, ',', '.') : '-'),
                ]),

            Textarea::make('notes')->columnSpanFull(),
        ]);
    }
}
