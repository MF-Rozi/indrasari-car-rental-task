<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('rental record can be created with valid relationships and attributes', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create(['daily_rate' => 500000]);

    $rental = Rental::create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'start_date' => '2026-09-01',
        'end_date' => '2026-09-03',
        'total_days' => 3,
        'estimated_price' => 1500000,
        'status' => 'active',
    ]);

    expect($rental->user->id)->toBe($user->id)
        ->and($rental->car->id)->toBe($car->id)
        ->and($user->rentals)->toHaveCount(1)
        ->and($car->rentals)->toHaveCount(1)
        ->and($rental->formatted_estimated_price)->toBe('Rp 1.500.000');
});

test('rental status helpers identify active, upcoming, completed, and cancelled states', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create();

    // Active ongoing today
    $active = Rental::factory()->active()->create(['user_id' => $user->id, 'car_id' => $car->id]);
    expect($active->isActive())->toBeTrue()
        ->and($active->isUpcoming())->toBeFalse()
        ->and($active->isCancellable())->toBeFalse();

    // Upcoming in future
    $upcoming = Rental::factory()->upcoming()->create(['user_id' => $user->id, 'car_id' => $car->id]);
    expect($upcoming->isUpcoming())->toBeTrue()
        ->and($upcoming->isCancellable())->toBeTrue();

    // Completed
    $completed = Rental::factory()->completed()->create(['user_id' => $user->id, 'car_id' => $car->id]);
    expect($completed->isCompleted())->toBeTrue()
        ->and($completed->isCancellable())->toBeFalse()
        ->and($completed->formatted_final_price)->not->toBeNull();

    // Cancelled
    $cancelled = Rental::factory()->cancelled()->create(['user_id' => $user->id, 'car_id' => $car->id]);
    expect($cancelled->isCancelled())->toBeTrue()
        ->and($cancelled->isCancellable())->toBeFalse();
});
