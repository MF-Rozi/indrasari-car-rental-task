<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can view register page', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('guest can view login page', function () {
    $response = $this->get(route('login'));

    $response->assertOk();
});

test('customer can register successfully and is redirected to catalog', function () {
    $payload = [
        'name' => 'Jane Customer',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone_number' => '081122334455',
        'address' => 'Jl. Thamrin No. 5, Jakarta',
        'sim_number' => 'SIM-987654321',
    ];

    $response = $this->post(route('register'), $payload);

    $response->assertRedirect(route('catalog.index'));
    $this->assertAuthenticated();

    $user = User::where('email', 'jane@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('Jane Customer')
        ->and($user->role)->toBe('customer')
        ->and($user->sim_number)->toBe('SIM-987654321');
});

test('customer registration with injected role payload protects against privilege escalation', function () {
    $payload = [
        'name' => 'Malicious User',
        'email' => 'malicious@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone_number' => '081199887766',
        'address' => 'Jl. Kebon Jeruk, Jakarta',
        'sim_number' => 'SIM-HACK-001',
        'role' => 'admin', // Attempted injection
    ];

    $response = $this->post(route('register'), $payload);

    $response->assertRedirect(route('catalog.index'));

    $user = User::where('email', 'malicious@example.com')->first();
    expect($user->role)->toBe('customer'); // Must remain customer
});

test('registration fails when email is already registered', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->from(route('register'))->post(route('register'), [
        'name' => 'Another User',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone_number' => '081234567890',
        'address' => 'Jakarta',
        'sim_number' => 'SIM-NEW-123',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('registration fails when sim number is already registered', function () {
    User::factory()->create(['sim_number' => 'SIM-TAKEN-001']);

    $response = $this->from(route('register'))->post(route('register'), [
        'name' => 'Another User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone_number' => '081234567890',
        'address' => 'Jakarta',
        'sim_number' => 'SIM-TAKEN-001',
    ]);

    $response->assertRedirect(route('register'));
    $response->assertSessionHasErrors('sim_number');
    $this->assertGuest();
});

test('customer login redirects to catalog', function () {
    $customer = User::factory()->create([
        'email' => 'customer@example.com',
        'password' => 'password123',
        'role' => 'customer',
    ]);

    $response = $this->post(route('login'), [
        'email' => 'customer@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('catalog.index'));
    $this->assertAuthenticatedAs($customer);
});

test('admin login redirects to admin dashboard', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@example.com',
        'password' => 'adminpass123',
    ]);

    $response = $this->post(route('login'), [
        'email' => 'admin@example.com',
        'password' => 'adminpass123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('login fails with invalid password', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'correct-password',
    ]);

    $response = $this->from(route('login'))->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('authenticated user can log out successfully', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('non-admin user receives 403 forbidden when accessing admin dashboard', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($customer)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin user can access admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
});

test('unauthenticated guest is redirected to login when accessing admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});
