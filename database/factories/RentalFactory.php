<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::today()->addDays(fake()->numberBetween(1, 10));
        $totalDays = fake()->numberBetween(1, 5);
        $endDate = (clone $startDate)->addDays($totalDays - 1);
        $rate = 500000;

        return [
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_days' => $totalDays,
            'estimated_price' => $totalDays * $rate,
            'actual_return_date' => null,
            'final_price' => null,
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the rental is currently ongoing today.
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::today();
            $totalDays = 3;
            $endDate = Carbon::today()->addDays($totalDays - 1);

            return [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_days' => $totalDays,
                'status' => 'active',
            ];
        });
    }

    /**
     * Indicate that the rental is upcoming in the future.
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::today()->addDays(5);
            $totalDays = 2;
            $endDate = Carbon::today()->addDays(6);

            return [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_days' => $totalDays,
                'status' => 'active',
            ];
        });
    }

    /**
     * Indicate that the rental has been completed.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::today()->subDays(5);
            $endDate = Carbon::today()->subDays(2);
            $returnDate = Carbon::today()->subDays(2);
            $totalDays = 4;
            $estimated = $totalDays * 500000;

            return [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_days' => $totalDays,
                'estimated_price' => $estimated,
                'actual_return_date' => $returnDate->toDateString(),
                'final_price' => $estimated,
                'status' => 'completed',
            ];
        });
    }

    /**
     * Indicate that the rental has been cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
