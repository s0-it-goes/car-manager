<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\DocumentController;

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
    Route::get('/clients/create/client', [ClientController::class, 'create'])
        ->name('clients.create.client');
    Route::get('/clients/create/dealer', [ClientController::class, 'create'])
        ->name('clients.create.dealer');
    Route::get('/clients/create/type', function () {
        return view('clients.create.type');
    })->name('clients.create.type');
    Route::get('/clients/{type}/{id}', [ClientController::class, 'show'])
        ->where('type', 'client|dealer')
        ->name('clients.show');
    Route::post('/clients/create/client', [ClientController::class, 'storeClient'])
        ->name('clients.store.client');
    Route::post('/clients/create/dealer', [ClientController::class, 'storeDealer'])
        ->name('clients.store.dealer');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
        ->name('clients.destroy');
    Route::delete('/dealers/{dealer}', [ClientController::class, 'destroyDealer'])
        ->name('dealers.destroy');
    Route::get('/clients/{type}/{id}/edit', [ClientController::class, 'edit'])
        ->where('type', 'client|dealer')
        ->name('clients.edit');
    Route::put('/clients/{type}/{id}', [ClientController::class, 'update'])
        ->where('type', 'client|dealer')
        ->name('clients.update');
    
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])
        ->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])
        ->name('orders.store');
    Route::get('/orders/{car}', [OrderController::class, 'show'])
        ->name('orders.show');
    Route::put('/orders/{car}', [OrderController::class, 'update'])
        ->name('orders.update');
    Route::delete('/orders/{car}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');
    Route::put('/orders/{car}', [OrderController::class, 'update'])
        ->name('orders.update');


    Route::post('/orders/{car}/photos',
        [PhotoController::class, 'store']
    )->name('orders.photos.upload');
    Route::delete('/photos/{photo}',
        [PhotoController::class, 'destroy']
    )->name('photos.delete');
    Route::post('/orders/{car}/documents',
        [DocumentController::class, 'store']
    )->name('orders.documents.upload');
    Route::delete('/documents/{document}',
        [DocumentController::class, 'destroy']
    )->name('documents.delete');

    Route::get('/archive', function () {
        return view('archive.index');
        })->name('archive.index');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');
    Route::put('/profile/server-payment', [ProfileController::class, 'updateServerPayment'])
        ->name('profile.server-payment.update');

    Route::get('/archive', [ArchiveController::class, 'index'])
        ->name('archive.index');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});