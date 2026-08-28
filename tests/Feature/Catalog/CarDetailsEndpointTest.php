<?php

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('customer can view individual vehicle details', function () {
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Fortuner 2.8 GR',
        'license_plate' => 'B 8888 FTR',
        'daily_rate' => 1200000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
    ]);

    $response = $this->get(route('catalog.show', $car));

    $response->assertOk()
        ->assertViewHas('car')
        ->assertViewHas('relatedCars');
});

test('viewing soft-deleted car returns 404 not found', function () {
    $car = Car::factory()->create();
    $car->delete();

    $response = $this->get(route('catalog.show', $car->id));

    $response->assertNotFound();
});
