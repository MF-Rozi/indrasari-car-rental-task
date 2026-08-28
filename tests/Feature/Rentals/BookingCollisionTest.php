<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('booking service calculates days and estimated price accurately', function () {
    $service = new BookingService();
    $user = User::factory()->create();
    $car = Car::factory()->create(['daily_rate' => 500000]);

    $startDate = Carbon::today()->addDays(2)->toDateString();
    $endDate = Carbon::today()->addDays(4)->toDateString(); // 3 days inclusive

    $rental = $service->createBooking($user, $car, $startDate, $endDate);

    expect($rental->total_days)->toBe(3)
        ->and($rental->estimated_price)->toBe(1500000)
        ->and($rental->status)->toBe('active');
});

test('booking service updates car status to rented when starting today', function () {
    $service = new BookingService();
    $user = User::factory()->create();
    $car = Car::factory()->create(['status' => 'available']);

    $startDate = Carbon::today()->toDateString();
    $endDate = Carbon::today()->addDays(2)->toDateString();

    $rental = $service->createBooking($user, $car, $startDate, $endDate);

    $car->refresh();
    expect($car->status)->toBe('rented')
        ->and($rental->isActive())->toBeTrue();
});

test('booking service prevents date overlap collision on the same car', function () {
    $service = new BookingService();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $car = Car::factory()->create();

    // User 1 books Sept 10 to Sept 15
    $service->createBooking($user1, $car, '2026-09-10', '2026-09-15');

    // User 2 attempts overlapping booking Sept 12 to Sept 18
    expect(fn () => $service->createBooking($user2, $car, '2026-09-12', '2026-09-18'))
        ->toThrow(ValidationException::class);
});

test('booking service allows non-overlapping booking for same car', function () {
    $service = new BookingService();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $car = Car::factory()->create();

    // User 1 books Sept 10 to Sept 15
    $service->createBooking($user1, $car, '2026-09-10', '2026-09-15');

    // User 2 books Sept 16 to Sept 20 (non-overlapping)
    $rental2 = $service->createBooking($user2, $car, '2026-09-16', '2026-09-20');

    expect($rental2)->not->toBeNull()
        ->and($rental2->status)->toBe('active');
});

test('booking service rejects reservation on maintenance vehicle', function () {
    $service = new BookingService();
    $user = User::factory()->create();
    $car = Car::factory()->maintenance()->create();

    expect(fn () => $service->createBooking($user, $car, '2026-09-10', '2026-09-15'))
        ->toThrow(ValidationException::class);
});
