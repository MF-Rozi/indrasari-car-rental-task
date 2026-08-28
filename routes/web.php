<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public & Catalog routes
Route::get('/', function () {
    return redirect()->route('catalog.index');
});

Route::get('/catalog', function () {
    return view('catalog.index');
})->name('catalog.index');

// Guest Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated User routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Customer Portal Placeholders
    Route::get('/my-rentals', function () {
        return view('rentals.my-rentals');
    })->name('rentals.my-rentals');

    Route::get('/rentals/return', function () {
        return view('rentals.return');
    })->name('rentals.return');
});

// Admin Protected routes
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class)->except(['show']);

    Route::get('/bookings', function () {
        return view('admin.bookings.index');
    })->name('bookings.index');
});
