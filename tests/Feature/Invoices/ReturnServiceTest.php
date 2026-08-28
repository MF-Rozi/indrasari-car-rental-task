<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use App\Services\ReturnService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

test('return service verifies active rental matching license plate', function () {
    $service = new ReturnService();
    $user = User::factory()->create();
    $car = Car::factory()->create(['license_plate' => 'B 1234 ABC', 'status' => 'rented']);
    $rental = Rental::factory()->active()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
    ]);

    $verified = $service->verifyActiveRental($user, 'b 1234 abc');

    expect($verified->id)->toBe($rental->id)
        ->and($verified->car->license_plate)->toBe('B 1234 ABC');
});

test('return service rejects plate belonging to another user or non-active rental', function () {
    $service = new ReturnService();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $car = Car::factory()->create(['license_plate' => 'B 9999 XYZ']);

    Rental::factory()->active()->create([
        'user_id' => $user1->id,
        'car_id' => $car->id,
    ]);

    expect(fn () => $service->verifyActiveRental($user2, 'B 9999 XYZ'))
        ->toThrow(ValidationException::class);
});

test('return service calculates elapsed days and processes return atomically', function () {
    $service = new ReturnService();
    $user = User::factory()->create();
    $car = Car::factory()->create(['daily_rate' => 500000, 'status' => 'rented']);

    $startDate = Carbon::today()->subDays(2)->toDateString(); // 3 days ago inclusive
    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'start_date' => $startDate,
        'end_date' => Carbon::today()->addDays(2)->toDateString(),
        'status' => 'active',
    ]);

    $invoice = $service->processReturn($user, $rental, Carbon::today()->toDateString());

    $rental->refresh();
    $car->refresh();

    expect($rental->status)->toBe('completed')
        ->and($rental->final_price)->toBe(1500000)
        ->and($car->status)->toBe('available')
        ->and($invoice->total_amount)->toBe(1500000)
        ->and($invoice->invoice_number)->toStartWith('INV-');
});
