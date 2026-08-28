<?php

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('vehicle details page renders specifications and booking estimator', function () {
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Fortuner 2.8 GR',
        'license_plate' => 'B 8888 FTR',
        'daily_rate' => 1250000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
    ]);

    $response = $this->get(route('catalog.show', $car));

    $response->assertOk()
        ->assertSee('Fortuner 2.8 GR')
        ->assertSee('B 8888 FTR')
        ->assertSee('Automatic')
        ->assertSee('7 Passengers')
        ->assertSee('Rp 1.250.000 / day')
        ->assertSee('Pricing Summary')
        ->assertSee('calculateRentalTotal', false);
});
