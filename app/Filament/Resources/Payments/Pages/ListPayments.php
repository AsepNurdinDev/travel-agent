<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        // No create action: payments are only recorded via a booking's
        // "Record payment" action (PaymentsRelationManager on BookingResource).
        return [];
    }
}
