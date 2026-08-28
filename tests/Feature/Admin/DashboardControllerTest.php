<?php

use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('non admin users are denied access to admin dashboard', function () {
    $customer = User::factory()->customer()->create();

    $this->actingAs($customer)->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admin dashboard computes accurate fleet and financial metrics', function () {
    $admin = User::factory()->admin()->create();

    // 2 available cars, 1 rented car
    $availableCars = Car::factory()->available()->count(2)->create();
    $rentedCar = Car::factory()->rented()->create();

    // 2 customers
    $customer1 = User::factory()->customer()->create();
    $customer2 = User::factory()->customer()->create();

    // 1 active rental
    $rental = Rental::factory()->active()->create([
        'user_id' => $customer1->id,
        'car_id' => $rentedCar->id,
    ]);

    // 1 paid invoice with 1,500,000 IDR
    $completedRental = Rental::factory()->completed()->create([
        'user_id' => $customer2->id,
        'car_id' => $availableCars[0]->id,
        'final_price' => 1500000,
    ]);
    Invoice::create([
        'rental_id' => $completedRental->id,
        'invoice_number' => 'INV-20260901-0001',
        'total_amount' => 1500000,
        'payment_status' => 'paid',
        'issued_at' => now(),
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertViewHas('totalCars', 3)
        ->assertViewHas('availableCars', 2)
        ->assertViewHas('rentedCars', 1)
        ->assertViewHas('activeRentals', 1)
        ->assertViewHas('totalCustomers', 2)
        ->assertViewHas('totalRevenue', 1500000)
        ->assertViewHas('formattedTotalRevenue', 'Rp 1.500.000');
});
