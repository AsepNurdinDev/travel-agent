<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * NOTE: total_amount, subtotal, discount_amount, price_* and amount_paid
     * must only ever be written by BookingPricingService / PaymentService.
     * Never mass-assign these from raw request input.
     */
    protected $fillable = [
        'booking_code',
        'customer_id',
        'tour_package_id',
        'tour_package_availability_id',
        'promotion_id',
        'adult_count',
        'child_count',
        'infant_count',
        'price_adult',
        'price_child',
        'price_infant',
        'addons_total',
        'subtotal',
        'discount_amount',
        'total_amount',
        'amount_paid',
        'status',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'price_adult' => 'decimal:2',
            'price_child' => 'decimal:2',
            'price_infant' => 'decimal:2',
            'addons_total' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'amount_paid' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function availability(): BelongsTo
    {
        return $this->belongsTo(TourPackageAvailability::class, 'tour_package_availability_id');
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getBalanceDueAttribute(): string
    {
        return bcsub((string) $this->total_amount, (string) $this->amount_paid, 2);
    }
}
