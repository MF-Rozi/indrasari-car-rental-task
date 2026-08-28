<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReturnService
{
    /**
     * Verify that an active rental exists for the user and license plate.
     *
     * @throws ValidationException
     */
    public function verifyActiveRental(User $user, string $licensePlate): Rental
    {
        $normalizedPlate = strtolower(str_replace(' ', '', $licensePlate));

        $rental = Rental::with('car')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->whereHas('car', function ($q) use ($normalizedPlate) {
                $q->whereRaw('REPLACE(LOWER(license_plate), " ", "") = ?', [$normalizedPlate]);
            })
            ->first();

        if (! $rental) {
            throw ValidationException::withMessages([
                'license_plate' => 'No active rental found for license plate "' . $licensePlate . '" under your account.',
            ]);
        }

        return $rental;
    }

    /**
     * Calculate elapsed days, daily rate, and total charges for a return.
     *
     * @return array<string, mixed>
     */
    public function calculateReturnSummary(Rental $rental, ?string $returnDate = null): array
    {
        $return = $returnDate ? Carbon::parse($returnDate)->startOfDay() : Carbon::today()->startOfDay();
        $start = Carbon::parse($rental->start_date)->startOfDay();

        // Calculate calendar days (minimum 1 day)
        $elapsedDays = max(1, (int) $start->diffInDays($return) + 1);
        $dailyRate = $rental->car->daily_rate;
        $finalAmount = $elapsedDays * $dailyRate;

        return [
            'start_date' => $start->toDateString(),
            'return_date' => $return->toDateString(),
            'elapsed_days' => $elapsedDays,
            'daily_rate' => $dailyRate,
            'formatted_daily_rate' => 'Rp ' . number_format($dailyRate, 0, ',', '.'),
            'final_amount' => $finalAmount,
            'formatted_final_amount' => 'Rp ' . number_format($finalAmount, 0, ',', '.'),
        ];
    }

    /**
     * Atomically process vehicle return, mark rental completed, restore vehicle status, and issue invoice.
     *
     * @throws ValidationException
     */
    public function processReturn(User $user, Rental $rental, ?string $returnDate = null): Invoice
    {
        return DB::transaction(function () use ($user, $rental, $returnDate) {
            $lockedRental = Rental::lockForUpdate()->find($rental->id);

            if (! $lockedRental || $lockedRental->user_id !== $user->id) {
                throw ValidationException::withMessages([
                    'rental' => 'You are not authorized to return this vehicle.',
                ]);
            }

            if ($lockedRental->status !== 'active') {
                throw ValidationException::withMessages([
                    'rental' => 'This rental is no longer active.',
                ]);
            }

            $summary = $this->calculateReturnSummary($lockedRental, $returnDate);

            // 1. Update Rental
            $lockedRental->update([
                'status' => 'completed',
                'actual_return_date' => $summary['return_date'],
                'final_price' => $summary['final_amount'],
            ]);

            // 2. Restore Car status to available
            $car = Car::find($lockedRental->car_id);
            if ($car) {
                $car->update(['status' => 'available']);
            }

            // 3. Generate unique invoice number: INV-YYYYMMDD-XXXX
            $invoiceNumber = 'INV-' . Carbon::today()->format('Ymd') . '-' . str_pad((string) $lockedRental->id, 4, '0', STR_PAD_LEFT);

            // 4. Create invoice
            return Invoice::create([
                'rental_id' => $lockedRental->id,
                'invoice_number' => $invoiceNumber,
                'total_amount' => $summary['final_amount'],
                'payment_status' => 'paid',
                'issued_at' => now(),
            ]);
        });
    }
}
