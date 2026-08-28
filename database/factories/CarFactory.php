<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $carCatalog = [
            ['brand' => 'Toyota', 'model' => 'Avanza 1.5 G', 'rate' => 450000, 'capacity' => 7],
            ['brand' => 'Toyota', 'model' => 'Innova Zenix Q Hybrid', 'rate' => 850000, 'capacity' => 7],
            ['brand' => 'Toyota', 'model' => 'Fortuner 2.8 GR Sport', 'rate' => 1200000, 'capacity' => 7],
            ['brand' => 'Honda', 'model' => 'Brio RS', 'rate' => 350000, 'capacity' => 5],
            ['brand' => 'Honda', 'model' => 'HR-V SE', 'rate' => 650000, 'capacity' => 5],
            ['brand' => 'Honda', 'model' => 'CR-V 1.5 Turbo', 'rate' => 950000, 'capacity' => 7],
            ['brand' => 'Mitsubishi', 'model' => 'Xpander Ultimate', 'rate' => 450000, 'capacity' => 7],
            ['brand' => 'Mitsubishi', 'model' => 'Pajero Sport Dakar', 'rate' => 1200000, 'capacity' => 7],
            ['brand' => 'Hyundai', 'model' => 'Ioniq 5 Signature', 'rate' => 1500000, 'capacity' => 5],
            ['brand' => 'Daihatsu', 'model' => 'Rocky 1.0 R Turbo', 'rate' => 400000, 'capacity' => 5],
        ];

        $car = fake()->randomElement($carCatalog);
        $platePrefix = fake()->randomElement(['B', 'D', 'F', 'L', 'AB']);
        $plateNumber = fake()->unique()->numberBetween(1000, 9999);
        $plateSuffix = fake()->lexify('???');

        return [
            'brand' => $car['brand'],
            'model' => $car['model'],
            'license_plate' => strtoupper("{$platePrefix} {$plateNumber} {$plateSuffix}"),
            'daily_rate' => $car['rate'],
            'transmission' => fake()->randomElement(['Automatic', 'Manual']),
            'seating_capacity' => $car['capacity'],
            'status' => 'available',
            'image_path' => null,
        ];
    }

    /**
     * Indicate that the car is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the car is currently rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rented',
        ]);
    }

    /**
     * Indicate that the car is under maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }
}
