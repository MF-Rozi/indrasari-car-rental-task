<?php

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dashboard view renders KPI performance cards and recent activity', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->customer()->create(['name' => 'Fakhrul Rozi']);
    $car = Car::factory()->create(['brand' => 'Toyota', 'model' => 'Fortuner GR', 'license_plate' => 'B 8888 FTR']);
    Rental::factory()->active()->create([
        'user_id' => $customer->id,
        'car_id' => $car->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('Admin Command Center')
        ->assertSee('Total Fleet')
        ->assertSee('Active Rentals')
        ->assertSee('Total Customers')
        ->assertSee('Total Settled Revenue')
        ->assertSee('Fakhrul Rozi')
        ->assertSee('Fortuner GR')
        ->assertSee('B 8888 FTR');
});
