<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('guest cannot access profile page', function () {
    $response = $this->get(route('profile.show'));

    $response->assertRedirect(route('login'));
});

test('authenticated user can view profile page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('profile.show'));

    $response->assertOk();
});

test('authenticated user can update profile details', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'phone_number' => '081111111111',
        'address' => 'Old Address',
        'sim_number' => 'SIM-ORIGINAL-01',
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'name' => 'Updated Name',
        'phone_number' => '082222222222',
        'address' => 'New Address, Jakarta',
        'sim_number' => 'SIM-UPDATED-02',
    ]);

    $response->assertRedirect(route('profile.show'));
    $response->assertSessionHas('success');

    $user->refresh();
    expect($user->name)->toBe('Updated Name')
        ->and($user->phone_number)->toBe('082222222222')
        ->and($user->address)->toBe('New Address, Jakarta')
        ->and($user->sim_number)->toBe('SIM-UPDATED-02');
});

test('profile update protects against role alteration', function () {
    $user = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'name' => $user->name,
        'phone_number' => $user->phone_number,
        'address' => $user->address,
        'sim_number' => $user->sim_number,
        'role' => 'admin', // Attempted role escalation
    ]);

    $response->assertRedirect(route('profile.show'));

    $user->refresh();
    expect($user->role)->toBe('customer');
});

test('profile update fails when changing sim number to another existing user sim', function () {
    User::factory()->create(['sim_number' => 'SIM-TAKEN-999']);
    $user = User::factory()->create(['sim_number' => 'SIM-MY-OWN-111']);

    $response = $this->actingAs($user)->from(route('profile.show'))->put(route('profile.update'), [
        'name' => $user->name,
        'phone_number' => $user->phone_number,
        'address' => $user->address,
        'sim_number' => 'SIM-TAKEN-999',
    ]);

    $response->assertRedirect(route('profile.show'));
    $response->assertSessionHasErrors('sim_number');
});

test('user can update password with valid current password and confirmation', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password-123'),
    ]);

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'name' => $user->name,
        'phone_number' => $user->phone_number,
        'address' => $user->address,
        'sim_number' => $user->sim_number,
        'current_password' => 'old-password-123',
        'password' => 'new-secure-password-456',
        'password_confirmation' => 'new-secure-password-456',
    ]);

    $response->assertRedirect(route('profile.show'));

    $user->refresh();
    expect(Hash::check('new-secure-password-456', $user->password))->toBeTrue();
});
