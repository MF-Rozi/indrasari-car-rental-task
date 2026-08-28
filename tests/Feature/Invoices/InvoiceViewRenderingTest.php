<?php

use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('invoice show view renders complete billing breakdown and printable receipt controls', function () {
    $user = User::factory()->create([
        'name' => 'Fakhrul Rozi',
        'sim_number' => 'SIM-12345678',
    ]);
    $car = Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Fortuner 2.8 GR',
        'license_plate' => 'B 8888 FTR',
    ]);
    $rental = Rental::factory()->completed()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'total_days' => 3,
        'final_price' => 3750000,
    ]);
    $invoice = Invoice::create([
        'rental_id' => $rental->id,
        'invoice_number' => 'INV-20260901-0099',
        'total_amount' => 3750000,
        'payment_status' => 'paid',
        'issued_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('invoices.show', $invoice));

    $response->assertOk()
        ->assertSee('INV-20260901-0099')
        ->assertSee('Fakhrul Rozi')
        ->assertSee('SIM-12345678')
        ->assertSee('Fortuner 2.8 GR')
        ->assertSee('B 8888 FTR')
        ->assertSee('3 Days')
        ->assertSee('Rp 3.750.000')
        ->assertSee('Print / Download Receipt');
});
