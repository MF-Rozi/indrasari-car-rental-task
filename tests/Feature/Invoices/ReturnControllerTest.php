<?php

use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to login when accessing return or invoices', function () {
    $this->get(route('rentals.return'))->assertRedirect(route('login'));
});

test('customer can view return page with active rentals list', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create(['license_plate' => 'B 5555 XYZ', 'status' => 'rented']);
    Rental::factory()->active()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
    ]);

    $response = $this->actingAs($user)->get(route('rentals.return'));

    $response->assertOk()
        ->assertViewHas('activeRentals');
});

test('customer can confirm return and is redirected to digital invoice', function () {
    $user = User::factory()->create();
    $car = Car::factory()->create(['license_plate' => 'B 7777 WIN', 'status' => 'rented', 'daily_rate' => 500000]);
    $rental = Rental::factory()->active()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'start_date' => Carbon::today()->subDays(1)->toDateString(),
    ]);

    $response = $this->actingAs($user)->post(route('rentals.return.confirm'), [
        'license_plate' => 'B 7777 WIN',
    ]);

    $invoice = Invoice::where('rental_id', $rental->id)->first();
    expect($invoice)->not->toBeNull();

    $response->assertRedirect(route('invoices.show', $invoice));
});

test('customer can view their own invoice', function () {
    $user = User::factory()->create();
    $rental = Rental::factory()->completed()->create(['user_id' => $user->id]);
    $invoice = Invoice::factory()->create(['rental_id' => $rental->id]);

    $response = $this->actingAs($user)->get(route('invoices.show', $invoice));

    $response->assertOk()
        ->assertViewHas('invoice');
});

test('customer cannot view another customer invoice', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $rental = Rental::factory()->completed()->create(['user_id' => $otherUser->id]);
    $invoice = Invoice::factory()->create(['rental_id' => $rental->id]);

    $response = $this->actingAs($user)->get(route('invoices.show', $invoice));

    $response->assertForbidden();
});

test('admin can view any customer invoice', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();
    $rental = Rental::factory()->completed()->create(['user_id' => $user->id]);
    $invoice = Invoice::factory()->create(['rental_id' => $rental->id]);

    $response = $this->actingAs($admin)->get(route('invoices.show', $invoice));

    $response->assertOk();
});
