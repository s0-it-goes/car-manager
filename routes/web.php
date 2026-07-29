<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

// Гостевые маршруты (доступны только неавторизованным)
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login')->name('login.post');
});

// Маршруты только для авторизованных пользователей
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders.index');
    Route::get('/archive', function () {
        return view('archive.index');
    })->name('archive.index');
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});