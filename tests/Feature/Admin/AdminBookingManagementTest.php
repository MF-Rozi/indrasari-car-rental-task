<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can view all customer bookings and filter by status', function () {
    $admin = User::factory()->admin()->create();
    $activeRental = Rental::factory()->active()->create();
    $completedRental = Rental::factory()->completed()->create();

    $response = $this->actingAs($admin)->get(route('admin.bookings.index', ['status' => 'active']));

    $response->assertOk();
    $bookings = $response->viewData('bookings');
    expect($bookings->pluck('id'))->toContain($activeRental->id)
        ->and($bookings->pluck('id'))->not->toContain($completedRental->id);
});

test('admin can search bookings by customer name or license plate', function () {
    $admin = User::factory()->admin()->create();

    $john = User::factory()->customer()->create(['name' => 'John Wick']);
    $carJohn = Car::factory()->create(['license_plate' => 'B 7777 WCK']);
    $rentalJohn = Rental::factory()->create(['user_id' => $john->id, 'car_id' => $carJohn->id]);

    $jane = User::factory()->customer()->create(['name' => 'Jane Doe']);
    $carJane = Car::factory()->create(['license_plate' => 'B 1111 JNE']);
    $rentalJane = Rental::factory()->create(['user_id' => $jane->id, 'car_id' => $carJane->id]);

    // Search by name
    $resName = $this->actingAs($admin)->get(route('admin.bookings.index', ['search' => 'Wick']));
    expect($resName->viewData('bookings')->pluck('id'))->toContain($rentalJohn->id)
        ->and($resName->viewData('bookings')->pluck('id'))->not->toContain($rentalJane->id);

    // Search by plate
    $resPlate = $this->actingAs($admin)->get(route('admin.bookings.index', ['search' => '1111 JNE']));
    expect($resPlate->viewData('bookings')->pluck('id'))->toContain($rentalJane->id)
        ->and($resPlate->viewData('bookings')->pluck('id'))->not->toContain($rentalJohn->id);
});

test('admin can view single booking audit inspection', function () {
    $admin = User::factory()->admin()->create();
    $rental = Rental::factory()->completed()->create();

    $response = $this->actingAs($admin)->get(route('admin.bookings.show', $rental));

    $response->assertOk()
        ->assertViewHas('rental');
});
