<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('checkout view renders driver profile, vehicle details, and booking controls', function () {
    $user = User::factory()->create([
        'name' => 'Fakhrul Rozi',
        'sim_number' => 'SIM-99887766',
    ]);
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Fortuner 2.8 GR',
        'license_plate' => 'B 8888 FTR',
        'daily_rate' => 1250000,
    ]);

    $response = $this->actingAs($user)->get(route('rentals.checkout', $car));

    $response->assertOk()
        ->assertSee('Review and Confirm Reservation')
        ->assertSee('Fakhrul Rozi')
        ->assertSee('SIM-99887766')
        ->assertSee('Fortuner 2.8 GR')
        ->assertSee('B 8888 FTR')
        ->assertSee('Confirm Reservation')
        ->assertSee('calculateRentalTotal', false);
});
