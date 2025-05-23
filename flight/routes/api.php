<?php

use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\FlightExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightApiController;
use App\Http\Controllers\FlightExport;
use App\Http\Controllers\Admin\PassengerController;
use App\Http\Controllers\Admin\PassengerExportController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\PassengerExport;
use App\Http\Controllers\AuthApiController;
use Illuminate\Contracts\Session\Session;

Route::middleware('security.headers')->group(function () {

    Route::post('register', [SessionController::class, 'register']);
    Route::post('login', [SessionController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [SessionController::class, 'logout']);

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/passengers/export', [PassengerExportController::class, 'export']);
        Route::apiResource('passengers', PassengerController::class);


        Route::get('flights/export', [FlightExportController::class, 'export']);
        Route::apiResource('flights', FlightController::class);
    });
});
