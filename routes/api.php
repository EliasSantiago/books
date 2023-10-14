<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/register','register');
            Route::post('/login', 'login');
        });
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/token', 'getToken');
        });

        Route::controller(BookController::class)->group(function () {
            Route::post('/books', 'store');
            Route::get('/books', 'index');
        });
    });
});

