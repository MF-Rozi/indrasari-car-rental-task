<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'brand',
    'model',
    'license_plate',
    'daily_rate',
    'transmission',
    'seating_capacity',
    'status',
    'image_path',
])]
class Car extends Model
{
    /** @use HasFactory<CarFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'daily_rate' => 'integer',
            'seating_capacity' => 'integer',
        ];
    }

    /**
     * Check if the vehicle is currently available for rent.
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if the vehicle is currently rented.
     */
    public function isRented(): bool
    {
        return $this->status === 'rented';
    }

    /**
     * Check if the vehicle is in maintenance.
     */
    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    /**
     * Get the formatted daily rate in Indonesian Rupiah (IDR).
     */
    public function getFormattedDailyRateAttribute(): string
    {
        return 'Rp ' . number_format($this->daily_rate, 0, ',', '.') . ' / day';
    }

    /**
     * Get the full publicly accessible image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
