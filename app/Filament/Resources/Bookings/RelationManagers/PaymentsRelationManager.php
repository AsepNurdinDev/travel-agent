<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use App\Services\Payment\PaymentService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

/**
 * No generic create/edit form here on purpose. A payment is only ever
 * recorded via the "Record payment" action below, which validates the
 * amount against the outstanding balance and goes through PaymentService
 * — an admin can never type an arbitrary amount/status directly onto a
 * Payment row. Refunds are the only other mutation, also service-backed.
 */
class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('payment_code')
            ->columns([
                TextColumn::make('payment_code'),
                TextColumn::make('amount')->money('IDR'),
                TextColumn::make('method')->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        'refunded' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')->dateTime(),
                TextColumn::make('verifiedBy.name')->label('Verified by'),
            ])
            ->headerActions([
                Action::make('recordPayment')
                    ->label('Record payment')
                    ->visible(fn () => Auth::user()?->can('payments.update'))
                    ->schema([
                        TextInput::make('amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0.01)
                            ->required(),
                        Select::make('method')
                            ->options([
                                'bank_transfer' => 'Bank Transfer',
                                'credit_card' => 'Credit Card',
                                'e_wallet' => 'E-Wallet',
                                'cash' => 'Cash',
                                'other' => 'Other',
                            ])
                            ->required(),
                        TextInput::make('transaction_id')->label('Transaction / reference ID'),
                    ])
                    ->action(function (array $data) {
                        app(PaymentService::class)->recordManualPayment(
                            booking: $this->getOwnerRecord(),
                            amount: (float) $data['amount'],
                            method: $data['method'],
                            verifiedByUserId: Auth::id(),
                            transactionId: $data['transaction_id'] ?? null,
                        );
                    }),
            ])
            ->recordActions([
                Action::make('refund')
                    ->label('Refund')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'paid' && Auth::user()?->can('payments.update'))
                    ->action(fn ($record) => app(PaymentService::class)->refundPayment($record)),
            ]);
    }
}
