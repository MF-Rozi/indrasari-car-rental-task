<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can view fleet index list with pagination', function () {
    $admin = User::factory()->admin()->create();
    Car::factory()->count(15)->create();

    $response = $this->actingAs($admin)->get(route('admin.cars.index'));

    $response->assertOk()
        ->assertViewHas('cars')
        ->assertSee('Fleet Management');
});

test('admin can search cars by brand or license plate', function () {
    $admin = User::factory()->admin()->create();
    $targetCar = Car::factory()->create([
        'brand' => 'Mitsubishi',
        'model' => 'Pajero Sport',
        'license_plate' => 'B 9999 PJR',
    ]);
    Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Avanza',
        'license_plate' => 'B 1111 TYA',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.cars.index', ['search' => 'Pajero']));

    $response->assertOk()
        ->assertSee('Mitsubishi')
        ->assertSee('B 9999 PJR')
        ->assertDontSee('B 1111 TYA');
});

test('admin can filter fleet by status', function () {
    $admin = User::factory()->admin()->create();
    $availableCar = Car::factory()->create([
        'brand' => 'Honda Brio',
        'license_plate' => 'B 1111 AVAIL',
        'status' => 'available',
    ]);
    $maintenanceCar = Car::factory()->create([
        'brand' => 'Toyota Fortuner',
        'license_plate' => 'B 2222 MAINT',
        'status' => 'maintenance',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.cars.index', ['status' => 'maintenance']));

    $response->assertOk()
        ->assertSee('B 2222 MAINT')
        ->assertDontSee('B 1111 AVAIL');
});

test('admin can store a new vehicle with image upload', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    $image = UploadedFile::fake()->create('avanza.jpg', 500, 'image/jpeg');

    $response = $this->actingAs($admin)->post(route('admin.cars.store'), [
        'brand' => 'Toyota',
        'model' => 'Innova Zenix',
        'license_plate' => 'B 7777 ZNX',
        'daily_rate' => 850000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
        'status' => 'available',
        'image' => $image,
    ]);

    $response->assertRedirect(route('admin.cars.index'));
    $response->assertSessionHas('success');

    $car = Car::where('license_plate', 'B 7777 ZNX')->first();
    expect($car)->not->toBeNull()
        ->and($car->daily_rate)->toBe(850000)
        ->and($car->image_path)->not->toBeNull();

    Storage::disk('public')->assertExists($car->image_path);
});

test('admin can update vehicle details and replace image', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    $oldImage = UploadedFile::fake()->create('old.jpg', 300, 'image/jpeg');
    $oldPath = $oldImage->store('cars', 'public');

    $car = Car::factory()->create([
        'brand' => 'Honda',
        'model' => 'HR-V',
        'image_path' => $oldPath,
    ]);

    $newImage = UploadedFile::fake()->create('new.jpg', 400, 'image/jpeg');

    $response = $this->actingAs($admin)->put(route('admin.cars.update', $car), [
        'brand' => 'Honda',
        'model' => 'HR-V Turbo Prestige',
        'license_plate' => $car->license_plate,
        'daily_rate' => 750000,
        'transmission' => 'Automatic',
        'seating_capacity' => 5,
        'status' => 'maintenance',
        'image' => $newImage,
    ]);

    $response->assertRedirect(route('admin.cars.index'));

    $car->refresh();
    expect($car->model)->toBe('HR-V Turbo Prestige')
        ->and($car->daily_rate)->toBe(750000)
        ->and($car->status)->toBe('maintenance');

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($car->image_path);
});

test('admin cannot delete vehicle that is currently rented', function () {
    $admin = User::factory()->admin()->create();
    $car = Car::factory()->rented()->create();

    $response = $this->actingAs($admin)->delete(route('admin.cars.destroy', $car));

    $response->assertSessionHas('error');
    expect(Car::find($car->id))->not->toBeNull();
});

test('admin can delete available vehicle', function () {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    $image = UploadedFile::fake()->create('delete-test.jpg', 300, 'image/jpeg');
    $path = $image->store('cars', 'public');

    $car = Car::factory()->create([
        'status' => 'available',
        'image_path' => $path,
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.cars.destroy', $car));

    $response->assertRedirect(route('admin.cars.index'));
    $response->assertSessionHas('success');

    expect(Car::find($car->id))->toBeNull();
    Storage::disk('public')->assertMissing($path);
});
