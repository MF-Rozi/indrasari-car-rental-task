<?php

namespace App\Models;

use Database\Factories\RentalFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'car_id',
    'start_date',
    'end_date',
    'total_days',
    'estimated_price',
    'actual_return_date',
    'final_price',
    'status',
])]
class Rental extends Model
{
    /** @use HasFactory<RentalFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'actual_return_date' => 'date',
            'total_days' => 'integer',
            'estimated_price' => 'integer',
            'final_price' => 'integer',
        ];
    }

    /**
     * The customer who reserved the rental.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The rented vehicle.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Check if rental is actively ongoing today or in progress.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->start_date->isPast() || $this->start_date->isToday());
    }

    /**
     * Check if rental is reserved for a future start date.
     */
    public function isUpcoming(): bool
    {
        return $this->status === 'active' && $this->start_date->isFuture() && ! $this->start_date->isToday();
    }

    /**
     * Check if rental is completed and returned.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if rental has been cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Determine if customer can cancel this reservation.
     */
    public function isCancellable(): bool
    {
        return $this->status === 'active' && $this->start_date->isFuture() && ! $this->start_date->isToday();
    }

    /**
     * Get formatted estimated price in IDR.
     */
    public function getFormattedEstimatedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->estimated_price, 0, ',', '.');
    }

    /**
     * Get formatted final price in IDR.
     */
    public function getFormattedFinalPriceAttribute(): ?string
    {
        if ($this->final_price === null) {
            return null;
        }

        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }
}
