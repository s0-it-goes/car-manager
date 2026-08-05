<?php

use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;

Route::post('/upload-test', function(Request $request){

    file_put_contents(
        storage_path('logs/request.log'),
        json_encode([
            'length' => request()->header('content-length'),
            'files' => $request->allFiles(),
            'all' => $request->all(),
        ])
    );

    return 'ok';

});

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

    Route::post('/orders/{car}/photos',
        [OrderController::class, 'uploadPhotos']
        )->name('orders.photos.upload');
    Route::post('/orders/{car}/documents',
        [OrderController::class, 'uploadDocuments']
        )->name('orders.documents.upload');
    Route::delete('/photos/{photo}',
        [OrderController::class, 'deletePhoto']
        )->name('photos.delete');
    Route::delete('/documents/{document}',
        [OrderController::class, 'deleteDocument']
        )->name('documents.delete');

    Route::get('/archive', function () {
        return view('archive.index');
        })->name('archive.index');

    Route::get('/profile', function () {
        return view('profile.index');
        })->name('profile.index');

    Route::get('/archive', [ArchiveController::class, 'index'])
        ->name('archive.index');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});