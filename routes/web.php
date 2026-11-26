<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\LocationController;

Route::get('/', [ListingController::class, 'index'])
    ->name('home');

// Public listing routes
Route::get('/listings', [ListingController::class, 'index'])
    ->name('listings.index');

Route::get('/listing/{listing:slug}', [ListingController::class, 'show'])
    ->name('listings.show');

// Guest routes
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/master-data', [CommonController::class, 'index'])
    ->name('master-data');

    // Listing routes
    Route::get('/listings/create', [ListingController::class, 'create'])
        ->name('listings.create');

    Route::post('/listings', [ListingController::class, 'store'])
        ->name('listings.store');

    // Dynamic dropdown routes
    Route::get('/get-subcategories', [LocationController::class, 'subcategories'])
        ->name('get.subcategories');

    Route::get('/get-states', [LocationController::class, 'states'])
        ->name('get.states');

    Route::get('/get-cities', [LocationController::class, 'cities'])
        ->name('get.cities');

    Route::get('/get-areas', [LocationController::class, 'areas'])
        ->name('get.areas');

    Route::get('/my-listings', [ListingController::class, 'myListings'])
        ->name('listings.mine');

    Route::get('/my-listings/{listing}/edit', [ListingController::class, 'edit'])
    ->name('listings.edit');

    Route::put('/my-listings/{listing}', [ListingController::class, 'update'])
        ->name('listings.update');

    Route::delete('/my-listings/{listing}', [ListingController::class, 'destroy'])
        ->name('listings.destroy');

    Route::patch('/my-listings/{listing}/status', [ListingController::class, 'updateStatus'])
        ->name('listings.status');
});