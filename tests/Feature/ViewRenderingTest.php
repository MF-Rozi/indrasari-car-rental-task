<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('register page renders all required form input fields', function () {
    $response = $this->get(route('register'));

    $response->assertOk()
        ->assertSee('Create an Account')
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="phone_number"', false)
        ->assertSee('name="sim_number"', false)
        ->assertSee('name="address"', false)
        ->assertSee('name="password"', false)
        ->assertSee('name="password_confirmation"', false);
});

test('login page renders email and password fields', function () {
    $response = $this->get(route('login'));

    $response->assertOk()
        ->assertSee('Sign In')
        ->assertSee('name="email"', false)
        ->assertSee('name="password"', false)
        ->assertSee('name="remember"', false);
});

test('profile page displays authenticated user details', function () {
    $user = User::factory()->create([
        'name' => 'Michael Corleone',
        'email' => 'michael@example.com',
        'sim_number' => 'SIM-CORLEONE-01',
    ]);

    $response = $this->actingAs($user)->get(route('profile.show'));

    $response->assertOk()
        ->assertSee('Michael Corleone')
        ->assertSee('michael@example.com')
        ->assertSee('SIM-CORLEONE-01')
        ->assertSee('Personal Information')
        ->assertSee('Change Password');
});

test('navigation bar displays brand name and theme toggle button', function () {
    $response = $this->get(route('catalog.index'));

    $response->assertOk()
        ->assertSee('Indrasari')
        ->assertSee('Rent')
        ->assertSee('window.toggleTheme()', false);
});

test('authenticated user sees profile dropdown in navbar', function () {
    $user = User::factory()->create(['name' => 'Alice Renter']);

    $response = $this->actingAs($user)->get(route('catalog.index'));

    $response->assertOk()
        ->assertSee('Alice Renter')
        ->assertSee(route('profile.show'))
        ->assertSee(route('logout'));
});
