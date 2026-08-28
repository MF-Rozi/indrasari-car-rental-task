<?php

use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin bookings index renders data table with customer SIM and vehicle plate', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->customer()->create([
        'name' => 'Fakhrul Rozi',
        'sim_number' => 'SIM-99887711',
    ]);
    $car = Car::factory()->create([
        'brand' => 'Mitsubishi',
        'model' => 'Pajero Sport',
        'license_plate' => 'B 9999 PJR',
    ]);
    Rental::factory()->active()->create([
        'user_id' => $customer->id,
        'car_id' => $car->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.bookings.index'));

    $response->assertOk()
        ->assertSee('Customer Bookings and Rentals')
        ->assertSee('Fakhrul Rozi')
        ->assertSee('SIM: SIM-99887711')
        ->assertSee('Pajero Sport')
        ->assertSee('B 9999 PJR')
        ->assertSee('Audit');
});

test('admin booking show view renders customer driver details and invoice reference', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->customer()->create([
        'name' => 'Jane Renter',
        'sim_number' => 'SIM-55443322',
    ]);
    $car = Car::factory()->create([
        'brand' => 'Hyundai',
        'model' => 'Ioniq 5',
        'license_plate' => 'B 1000 ELE',
    ]);
    $rental = Rental::factory()->completed()->create([
        'user_id' => $customer->id,
        'car_id' => $car->id,
        'final_price' => 3000000,
    ]);
    $invoice = Invoice::create([
        'rental_id' => $rental->id,
        'invoice_number' => 'INV-20260901-0077',
        'total_amount' => 3000000,
        'payment_status' => 'paid',
        'issued_at' => now(),
    ]);

    $response = $this->actingAs($admin)->get(route('admin.bookings.show', $rental));

    $response->assertOk()
        ->assertSee('Jane Renter')
        ->assertSee('SIM-55443322')
        ->assertSee('Hyundai')
        ->assertSee('Ioniq 5')
        ->assertSee('B 1000 ELE')
        ->assertSee('INV-20260901-0077')
        ->assertSee('View Digital Invoice');
});
