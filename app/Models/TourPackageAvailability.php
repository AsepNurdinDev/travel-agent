<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackageAvailability extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_package_id',
        'departure_date',
        'return_date',
        'quota',
        'seats_booked',
        'price_adult_override',
        'price_child_override',
        'price_infant_override',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'return_date' => 'date',
            'price_adult_override' => 'decimal:2',
            'price_child_override' => 'decimal:2',
            'price_infant_override' => 'decimal:2',
        ];
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, $this->quota - $this->seats_booked);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
