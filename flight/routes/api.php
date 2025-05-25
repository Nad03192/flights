<?php

use App\Http\Controllers\Admin\AdminManagement;
use App\Http\Controllers\Admin\FlightController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PassengerController;
use App\Http\Controllers\Admin\PassengerExportController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Admin\PassengerImageController;

Route::middleware(['throttle:3,1', 'security.headers'])->group(function () {
    Route::post('register', [SessionController::class, 'register']);
    Route::post('login', [SessionController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [SessionController::class, 'logout']);

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('passengers/export', [PassengerExportController::class, 'export']);
        Route::apiResource('admin/users', AdminManagement::class);
        Route::apiResource('passengers', PassengerController::class);
        Route::post('passengers/{passenger}/image', [PassengerImageController::class, 'store']);
        Route::delete('passengers/{passenger}/image', [PassengerImageController::class, 'destroy']);
        Route::apiResource('flights', FlightController::class);
    });

    Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
        Route::get('user/flights', [FlightController::class, 'index']);
        Route::get('user/flights/{flight}', [FlightController::class, 'show']);
    });
});
