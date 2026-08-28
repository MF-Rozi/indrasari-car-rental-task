<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('return page renders plate input and active rentals quick select', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create([
        'brand' => 'Honda',
        'model' => 'HR-V SE',
        'license_plate' => 'B 5566 HRV',
    ]);
    Rental::factory()->active()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
    ]);

    $response = $this->actingAs($user)->get(route('rentals.return'));

    $response->assertOk()
        ->assertSee('Return Rented Vehicle')
        ->assertSee('Verify by License Plate')
        ->assertSee('HR-V SE')
        ->assertSee('B 5566 HRV');
});

test('return page displays verified calculation breakdown when plate query is provided', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create([
        'brand' => 'Mitsubishi',
        'model' => 'Xpander Cross',
        'license_plate' => 'B 3456 MIT',
        'daily_rate' => 500000,
    ]);
    Rental::factory()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'start_date' => Carbon::today()->subDays(2)->toDateString(),
        'end_date' => Carbon::today()->addDays(2)->toDateString(),
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get(route('rentals.return', ['license_plate' => 'B 3456 MIT']));

    $response->assertOk()
        ->assertSee('Vehicle Verified')
        ->assertSee('Xpander Cross')
        ->assertSee('3 Days')
        ->assertSee('Rp 1.500.000')
        ->assertSee('Confirm Return and Settle Invoice');
});
