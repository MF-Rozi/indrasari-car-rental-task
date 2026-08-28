<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user factory creates customer with all required profile attributes', function () {
    $user = User::factory()->create();

    expect($user->name)->toBeString()->not->toBeEmpty()
        ->and($user->email)->toBeString()->toContain('@')
        ->and($user->phone_number)->toBeString()->not->toBeEmpty()
        ->and($user->address)->toBeString()->not->toBeEmpty()
        ->and($user->sim_number)->toBeString()->not->toBeEmpty()
        ->and($user->role)->toBe('customer')
        ->and($user->isCustomer())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse();
});

test('user factory admin state creates administrator account', function () {
    $admin = User::factory()->admin()->create();

    expect($admin->role)->toBe('admin')
        ->and($admin->isAdmin())->toBeTrue()
        ->and($admin->isCustomer())->toBeFalse();
});

test('unique constraint prevents duplicate email', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    expect(fn () => User::factory()->create(['email' => 'duplicate@example.com']))
        ->toThrow(QueryException::class);
});

test('unique constraint prevents duplicate sim number', function () {
    User::factory()->create(['sim_number' => 'SIM-UNIQUE-123']);

    expect(fn () => User::factory()->create(['sim_number' => 'SIM-UNIQUE-123']))
        ->toThrow(QueryException::class);
});

test('database seeder creates default admin and customer accounts', function () {
    $this->seed(DatabaseSeeder::class);

    $admin = User::where('email', 'admin@indrasari.test')->first();
    expect($admin)->not->toBeNull()
        ->and($admin->role)->toBe('admin')
        ->and($admin->sim_number)->toBe('ADMIN-001');

    $customer = User::where('email', 'customer@indrasari.test')->first();
    expect($customer)->not->toBeNull()
        ->and($customer->role)->toBe('customer')
        ->and($customer->sim_number)->toBe('123456789012');
});
