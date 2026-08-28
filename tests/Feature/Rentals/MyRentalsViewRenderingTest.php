<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('my rentals view renders filter tabs and booking card details', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create([
        'brand' => 'Hyundai',
        'model' => 'Ioniq 5 Signature',
        'license_plate' => 'B 1000 ELE',
    ]);

    $rental = Rental::factory()->upcoming()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'estimated_price' => 3000000,
    ]);

    $response = $this->actingAs($user)->get(route('rentals.my-rentals'));

    $response->assertOk()
        ->assertSee('My Rentals and Reservations')
        ->assertSee('All Bookings')
        ->assertSee('Active Ongoing')
        ->assertSee('Upcoming')
        ->assertSee('Hyundai')
        ->assertSee('Ioniq 5 Signature')
        ->assertSee('B 1000 ELE')
        ->assertSee('Rp 3.000.000')
        ->assertSee('Cancel Booking')
        ->assertSee('openCancelModal', false);
});

test('my rentals view displays empty state when no bookings exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('rentals.my-rentals'));

    $response->assertOk()
        ->assertSee('No reservations found')
        ->assertSee('Explore Available Fleet');
});
