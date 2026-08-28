<?php

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('scopeSearch matches vehicles by brand, model or plate', function () {
    $toyota = Car::factory()->create(['brand' => 'Toyota', 'model' => 'Avanza', 'license_plate' => 'B 1111 TYA']);
    $honda = Car::factory()->create(['brand' => 'Honda', 'model' => 'Brio', 'license_plate' => 'B 2222 HND']);

    $results = Car::query()->search('Avanza')->get();
    expect($results)->toHaveCount(1)
        ->and($results->first()->id)->toBe($toyota->id);

    $plateResults = Car::query()->search('2222 HND')->get();
    expect($plateResults)->toHaveCount(1)
        ->and($plateResults->first()->id)->toBe($honda->id);
});

test('scopeBrand filters accurately by brand name', function () {
    Car::factory()->create(['brand' => 'Toyota']);
    Car::factory()->create(['brand' => 'Honda']);
    Car::factory()->create(['brand' => 'Hyundai']);

    $toyotas = Car::query()->brand('Toyota')->get();
    expect($toyotas)->toHaveCount(1)
        ->and($toyotas->first()->brand)->toBe('Toyota');

    $allBrands = Car::query()->brand('all')->get();
    expect($allBrands)->toHaveCount(3);
});

test('scopeSortByRate sorts vehicles ascending and descending', function () {
    $cheap = Car::factory()->create(['daily_rate' => 300000]);
    $mid = Car::factory()->create(['daily_rate' => 600000]);
    $expensive = Car::factory()->create(['daily_rate' => 1200000]);

    $asc = Car::query()->sortByRate('price_asc')->pluck('daily_rate')->toArray();
    expect($asc)->toBe([300000, 600000, 1200000]);

    $desc = Car::query()->sortByRate('price_desc')->pluck('daily_rate')->toArray();
    expect($desc)->toBe([1200000, 600000, 300000]);
});

test('scopeAvailableForDates filters out maintenance status cars', function () {
    $available = Car::factory()->available()->create();
    $maintenance = Car::factory()->maintenance()->create();

    $results = Car::query()->availableForDates('2026-09-01', '2026-09-05')->get();

    expect($results->pluck('id'))->toContain($available->id)
        ->and($results->pluck('id'))->not->toContain($maintenance->id);
});
