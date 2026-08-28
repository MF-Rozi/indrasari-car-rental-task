<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('non-admin user cannot store a car', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($customer)->post(route('admin.cars.store'), [
        'brand' => 'Toyota',
        'model' => 'Avanza',
        'license_plate' => 'B 1234 ABC',
        'daily_rate' => 450000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
        'status' => 'available',
    ]);

    $response->assertForbidden();
});

test('store car fails when required fields are missing', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('admin.cars.store'), []);

    $response->assertSessionHasErrors([
        'brand',
        'model',
        'license_plate',
        'daily_rate',
        'transmission',
        'seating_capacity',
        'status',
    ]);
});

test('store car fails with invalid rate or seating capacity', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('admin.cars.store'), [
        'brand' => 'Toyota',
        'model' => 'Avanza',
        'license_plate' => 'B 1234 ABC',
        'daily_rate' => 500, // Too low (<10000)
        'transmission' => 'Automatic',
        'seating_capacity' => 0, // Invalid capacity (<1)
        'status' => 'available',
    ]);

    $response->assertSessionHasErrors(['daily_rate', 'seating_capacity']);
});

test('store car fails with invalid file upload', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    $file = UploadedFile::fake()->create('document.pdf', 500);

    $response = $this->actingAs($admin)->post(route('admin.cars.store'), [
        'brand' => 'Toyota',
        'model' => 'Avanza',
        'license_plate' => 'B 1234 ABC',
        'daily_rate' => 450000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
        'status' => 'available',
        'image' => $file,
    ]);

    $response->assertSessionHasErrors('image');
});

test('update car permits keeping the same license plate', function () {
    $admin = User::factory()->admin()->create();
    $car = Car::factory()->create(['license_plate' => 'B 7777 SAM']);

    $response = $this->actingAs($admin)->put(route('admin.cars.update', $car), [
        'brand' => 'Toyota Updated',
        'model' => 'Avanza Updated',
        'license_plate' => 'B 7777 SAM',
        'daily_rate' => 500000,
        'transmission' => 'Manual',
        'seating_capacity' => 7,
        'status' => 'available',
    ]);

    $response->assertSessionHasNoErrors();
    $car->refresh();
    expect($car->brand)->toBe('Toyota Updated');
});
