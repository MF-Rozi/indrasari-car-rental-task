<?php

use App\Models\Car;
use Database\Seeders\CarSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('car factory creates vehicle with valid attributes', function () {
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Avanza',
        'license_plate' => 'B 1234 ABC',
        'daily_rate' => 450000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
        'status' => 'available',
    ]);

    expect($car->brand)->toBe('Toyota')
        ->and($car->model)->toBe('Avanza')
        ->and($car->license_plate)->toBe('B 1234 ABC')
        ->and($car->daily_rate)->toBe(450000)
        ->and($car->formatted_daily_rate)->toBe('Rp 450.000 / day')
        ->and($car->isAvailable())->toBeTrue()
        ->and($car->isRented())->toBeFalse()
        ->and($car->isMaintenance())->toBeFalse();
});

test('unique constraint prevents duplicate license plate', function () {
    Car::factory()->create(['license_plate' => 'B 9999 DUP']);

    expect(fn () => Car::factory()->create(['license_plate' => 'B 9999 DUP']))
        ->toThrow(QueryException::class);
});

test('soft deletes preserves car in database and filters from default query', function () {
    $car = Car::factory()->create(['license_plate' => 'B 5555 DEL']);

    $car->delete();

    expect(Car::find($car->id))->toBeNull()
        ->and(Car::withTrashed()->find($car->id))->not->toBeNull();
});

test('car seeder creates initial fleet vehicles', function () {
    $this->seed(CarSeeder::class);

    expect(Car::count())->toBeGreaterThanOrEqual(10);

    $avanza = Car::where('license_plate', 'B 1024 TYA')->first();
    expect($avanza)->not->toBeNull()
        ->and($avanza->brand)->toBe('Toyota')
        ->and($avanza->daily_rate)->toBe(450000);
});
