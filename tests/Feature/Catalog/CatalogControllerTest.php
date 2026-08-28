<?php

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('root url redirects to catalog index', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('catalog.index'));
});

test('catalog index displays vehicles and distinct brands', function () {
    Car::factory()->create(['brand' => 'Toyota', 'model' => 'Avanza']);
    Car::factory()->create(['brand' => 'Honda', 'model' => 'Brio']);

    $response = $this->get(route('catalog.index'));

    $response->assertOk()
        ->assertViewHas('cars')
        ->assertViewHas('brands')
        ->assertSee('Toyota')
        ->assertSee('Honda');
});

test('catalog index filters by keyword and brand', function () {
    $toyota = Car::factory()->create(['brand' => 'Toyota', 'model' => 'Innova Zenix']);
    $honda = Car::factory()->create(['brand' => 'Honda', 'model' => 'HR-V']);

    $response = $this->get(route('catalog.index', [
        'brand' => 'Toyota',
        'search' => 'Zenix',
    ]));

    $response->assertOk();
    $cars = $response->viewData('cars');
    expect($cars->pluck('id'))->toContain($toyota->id)
        ->and($cars->pluck('id'))->not->toContain($honda->id);
});

test('catalog index sorts vehicles by daily rate ascending and descending', function () {
    $brio = Car::factory()->create(['brand' => 'Honda', 'model' => 'Brio', 'daily_rate' => 350000]);
    $pajero = Car::factory()->create(['brand' => 'Mitsubishi', 'model' => 'Pajero', 'daily_rate' => 1200000]);

    $responseAsc = $this->get(route('catalog.index', ['sort' => 'price_asc']));
    $responseAsc->assertOk();
    $carsAsc = $responseAsc->viewData('cars');
    expect($carsAsc->first()->id)->toBe($brio->id);

    $responseDesc = $this->get(route('catalog.index', ['sort' => 'price_desc']));
    $responseDesc->assertOk();
    $carsDesc = $responseDesc->viewData('cars');
    expect($carsDesc->first()->id)->toBe($pajero->id);
});
