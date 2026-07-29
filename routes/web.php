<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;

// Гостевые маршруты (доступны только неавторизованным)
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login')->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/clients', [ClientController::class, 'index'])
    ->name('clients.index');

    Route::get('/clients/create', [ClientController::class, 'create'])
    ->name('clients.create');
    Route::post('/clients/create', [ClientController::class, 'store'])
    ->name('clients.store');

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])
        ->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])
        ->name('orders.store');

    Route::get('/archive', function () {
        return view('archive.index');
    })->name('archive.index');

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});