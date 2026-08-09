<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Services\Booking\BookingService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cancelBooking')
                ->label('Cancel booking')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => ! in_array($this->record->status, ['cancelled', 'completed'], true))
                ->action(function () {
                    app(BookingService::class)->cancelBooking($this->record);
                    $this->redirect(self::getResource()::getUrl('index'));
                }),
            DeleteAction::make(),
        ];
    }

    /**
     * Defense in depth: even though customer/package/availability/price
     * fields are disabled (and therefore not dehydrated) in the form, we
     * explicitly strip anything price-related before it ever reaches
     * Eloquent::update(). Editing a booking must only ever change status
     * and notes — a re-price or seat change goes through cancel + rebook.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return array_intersect_key($data, array_flip(['status', 'notes']));
    }
}
