<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can view fleet management page with table and controls', function () {
    $admin = User::factory()->admin()->create();
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Fortuner',
        'license_plate' => 'B 8888 FTR',
        'daily_rate' => 1200000,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.cars.index'));

    $response->assertOk()
        ->assertSee('Fleet Management')
        ->assertSee('Add New Vehicle')
        ->assertSee('Toyota')
        ->assertSee('Fortuner')
        ->assertSee('B 8888 FTR')
        ->assertSee('Rp 1.200.000 / day')
        ->assertSee('openDeleteModal', false);
});

test('admin can render add vehicle form', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.cars.create'));

    $response->assertOk()
        ->assertSee('Add New Vehicle')
        ->assertSee('name="brand"', false)
        ->assertSee('name="model"', false)
        ->assertSee('name="license_plate"', false)
        ->assertSee('name="daily_rate"', false)
        ->assertSee('name="transmission"', false)
        ->assertSee('name="seating_capacity"', false)
        ->assertSee('name="status"', false)
        ->assertSee('name="image"', false);
});

test('admin can render edit vehicle form with prefilled values', function () {
    $admin = User::factory()->admin()->create();
    $car = Car::factory()->create([
        'brand' => 'Hyundai',
        'model' => 'Ioniq 5',
        'license_plate' => 'B 1000 ELE',
        'daily_rate' => 1500000,
        'transmission' => 'Automatic',
        'seating_capacity' => 5,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.cars.edit', $car));

    $response->assertOk()
        ->assertSee('Edit Vehicle')
        ->assertSee('Hyundai')
        ->assertSee('Ioniq 5')
        ->assertSee('B 1000 ELE')
        ->assertSee('1500000');
});
