<?php

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('catalog index renders vehicle cards with photos and details', function () {
    Car::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix Hybrid',
        'daily_rate' => 850000,
        'transmission' => 'Automatic',
        'seating_capacity' => 7,
    ]);

    $response = $this->get(route('catalog.index'));

    $response->assertOk()
        ->assertSee('Innova Zenix Hybrid')
        ->assertSee('Rp 850.000 / day')
        ->assertSee('Automatic')
        ->assertSee('7 Seats')
        ->assertSee('View Details');
});

test('catalog index displays empty state when no results match', function () {
    $response = $this->get(route('catalog.index', ['search' => 'NonExistentModel999']));

    $response->assertOk()
        ->assertSee('No vehicles found')
        ->assertSee('Clear All Filters');
});
