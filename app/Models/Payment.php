<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * Sensitive financial record. Do not expose free-form editing of
     * status/transaction_id/amount/paid_at in the admin UI — see
     * PaymentPolicy and PaymentService for the only sanctioned mutation paths.
     */
    protected $fillable = [
        'booking_id',
        'payment_code',
        'amount',
        'method',
        'status',
        'transaction_id',
        'paid_at',
        'gateway_response',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'gateway_response' => 'array',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
