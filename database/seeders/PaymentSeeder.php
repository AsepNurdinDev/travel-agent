<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Services\Payment\PaymentService;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $paymentService = app(PaymentService::class);

        Booking::query()->where('status', '!=', 'cancelled')->get()->each(function (Booking $booking) use ($paymentService) {
            // Randomly simulate: fully paid, partially paid (deposit), or unpaid.
            $scenario = fake()->randomElement(['full', 'deposit', 'none']);

            if ($scenario === 'none') {
                return;
            }

            $amount = $scenario === 'full'
                ? (float) $booking->total_amount
                : round((float) $booking->total_amount * 0.3, 2);

            if ($amount <= 0) {
                return;
            }

            $paymentService->recordManualPayment(
                booking: $booking,
                amount: $amount,
                method: fake()->randomElement(['bank_transfer', 'e_wallet', 'cash']),
                transactionId: strtoupper(fake()->bothify('TRX########')),
            );
        });
    }
}
