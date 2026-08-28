<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to login when accessing checkout or my rentals', function () {
    $car = Car::factory()->create();

    $this->get(route('rentals.checkout', $car))->assertRedirect(route('login'));
    $this->get(route('rentals.my-rentals'))->assertRedirect(route('login'));
});

test('customer can view booking checkout page', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create(['daily_rate' => 500000]);

    $response = $this->actingAs($user)->get(route('rentals.checkout', $car));

    $response->assertOk()
        ->assertViewHas('car')
        ->assertViewHas('user');
});

test('customer can submit booking and is redirected to my rentals with success banner', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create(['daily_rate' => 600000]);

    $startDate = Carbon::today()->addDays(1)->toDateString();
    $endDate = Carbon::today()->addDays(3)->toDateString();

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'car_id' => $car->id,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);

    $response->assertRedirect(route('rentals.my-rentals'));
    $response->assertSessionHas('success');

    $rental = Rental::where('car_id', $car->id)->where('user_id', $user->id)->first();
    expect($rental)->not->toBeNull()
        ->and($rental->total_days)->toBe(3)
        ->and($rental->estimated_price)->toBe(1800000);
});

test('customer can view their own rentals and filter by status', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $myRental = Rental::factory()->create(['user_id' => $user->id]);
    $otherRental = Rental::factory()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($user)->get(route('rentals.my-rentals'));

    $response->assertOk();
    $rentals = $response->viewData('rentals');
    expect($rentals->pluck('id'))->toContain($myRental->id)
        ->and($rentals->pluck('id'))->not->toContain($otherRental->id);
});

test('customer can cancel upcoming reservation before start date', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->upcoming()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('rentals.cancel', $rental));

    $response->assertRedirect(route('rentals.my-rentals'));
    $response->assertSessionHas('success');

    $rental->refresh();
    expect($rental->status)->toBe('cancelled');
});

test('customer cannot cancel another user reservation', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $rental = Rental::factory()->upcoming()->create(['user_id' => $otherUser->id]);

    $response = $this->actingAs($user)->post(route('rentals.cancel', $rental));

    $response->assertSessionHasErrors(['rental']);
    $rental->refresh();
    expect($rental->status)->toBe('active');
});
