<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{
    /**
     * Atomically create a booking reservation for a car and prevent date collisions.
     *
     * @throws ValidationException
     */
    public function createBooking(User $user, Car $car, string $startDate, string $endDate): Rental
    {
        return DB::transaction(function () use ($user, $car, $startDate, $endDate) {
            $lockedCar = Car::lockForUpdate()->find($car->id);

            if (! $lockedCar) {
                throw ValidationException::withMessages([
                    'car_id' => 'The selected vehicle does not exist.',
                ]);
            }

            if ($lockedCar->status === 'maintenance') {
                throw ValidationException::withMessages([
                    'car_id' => 'This vehicle is currently undergoing maintenance and is not available for reservation.',
                ]);
            }

            // Check for date overlap collision with any active reservation
            $hasCollision = Rental::where('car_id', $lockedCar->id)
                ->where('status', 'active')
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                        ->where('end_date', '>=', $startDate);
                })
                ->exists();

            if ($hasCollision) {
                throw ValidationException::withMessages([
                    'start_date' => 'This vehicle is already reserved for the selected dates.',
                ]);
            }

            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->startOfDay();
            $totalDays = (int) $start->diffInDays($end) + 1;
            $estimatedPrice = $totalDays * $lockedCar->daily_rate;

            $rental = Rental::create([
                'user_id' => $user->id,
                'car_id' => $lockedCar->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_days' => $totalDays,
                'estimated_price' => $estimatedPrice,
                'status' => 'active',
            ]);

            // If reservation starts today, mark car status as rented
            if ($start->isToday()) {
                $lockedCar->update(['status' => 'rented']);
            }

            return $rental;
        });
    }

    /**
     * Cancel an upcoming reservation before the start date and release vehicle availability.
     *
     * @throws ValidationException
     */
    public function cancelBooking(User $user, Rental $rental): Rental
    {
        if ($rental->user_id !== $user->id) {
            throw ValidationException::withMessages([
                'rental' => 'You are not authorized to cancel this reservation.',
            ]);
        }

        if (! $rental->isCancellable()) {
            throw ValidationException::withMessages([
                'rental' => 'Only upcoming reservations prior to the pick-up date can be cancelled.',
            ]);
        }

        return DB::transaction(function () use ($rental) {
            $rental->update(['status' => 'cancelled']);

            // If car was somehow flagged as rented, make it available
            $car = Car::find($rental->car_id);
            if ($car && $car->status === 'rented') {
                $hasOtherActiveToday = Rental::where('car_id', $car->id)
                    ->where('id', '!=', $rental->id)
                    ->where('status', 'active')
                    ->where('start_date', '<=', Carbon::today())
                    ->where('end_date', '>=', Carbon::today())
                    ->exists();

                if (! $hasOtherActiveToday) {
                    $car->update(['status' => 'available']);
                }
            }

            return $rental;
        });
    }
}
