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
     * Scope search query across brand, model, and license plate.
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (! empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('brand', 'like', "%{$keyword}%")
                    ->orWhere('model', 'like', "%{$keyword}%")
                    ->orWhere('license_plate', 'like', "%{$keyword}%");
            });
        }

        return $query;
    }

    /**
     * Scope query to filter by brand.
     */
    public function scopeBrand($query, ?string $brand)
    {
        if (! empty($brand) && strtolower($brand) !== 'all') {
            $query->where('brand', $brand);
        }

        return $query;
    }

    /**
     * Scope query to sort by daily rate or recency.
     */
    public function scopeSortByRate($query, ?string $sort)
    {
        if ($sort === 'price_asc') {
            return $query->orderBy('daily_rate', 'asc');
        }

        if ($sort === 'price_desc') {
            return $query->orderBy('daily_rate', 'desc');
        }

        return $query->latest();
    }

    /**
     * Scope query to filter available vehicles for a date range.
     */
    public function scopeAvailableForDates($query, ?string $startDate, ?string $endDate)
    {
        $query->where('status', '!=', 'maintenance');

        if ($startDate && $endDate && \Illuminate\Support\Facades\Schema::hasTable('rentals')) {
            $query->whereDoesntHave('rentals', function ($q) use ($startDate, $endDate) {
                $q->whereIn('status', ['active', 'confirmed', 'upcoming'])
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            });
        }

        return $query;
    }
}
