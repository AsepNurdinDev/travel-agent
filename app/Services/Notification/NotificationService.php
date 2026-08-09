<?php

namespace App\Services\Notification;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

/**
 * Thin façade over outbound notifications (email/WhatsApp). Production
 * email/WhatsApp delivery is out of scope for this pass, so every method
 * currently just logs — swap the body for real Mail::send()/API calls
 * without touching any caller.
 */
class NotificationService
{
    public function bookingCreated(Booking $booking): void
    {
        Log::info('notification.booking_created', ['booking_id' => $booking->id, 'booking_code' => $booking->booking_code]);
    }

    public function paymentConfirmed(Payment $payment): void
    {
        Log::info('notification.payment_confirmed', ['payment_id' => $payment->id, 'booking_id' => $payment->booking_id]);
    }

    public function bookingCancelled(Booking $booking): void
    {
        Log::info('notification.booking_cancelled', ['booking_id' => $booking->id]);
    }
}
