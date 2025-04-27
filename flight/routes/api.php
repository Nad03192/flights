<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightApiController;
use App\Http\Controllers\PassengerApiController;

// Already exists
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// =======================
// FLIGHT API Routes
// =======================
Route::prefix('flights')->group(function () {
    Route::get('/', [FlightApiController::class, 'index']);         // Get all flights
    Route::post('/', [FlightApiController::class, 'store']);        // Create new flight
    Route::get('/{id}', [FlightApiController::class, 'show']);      // Get flight by id
    Route::put('/{id}', [FlightApiController::class, 'update']);    // Update flight
    Route::delete('/{id}', [FlightApiController::class, 'destroy']); // Delete flight
});

// =======================
// PASSENGER API Routes
// =======================
Route::prefix('passengers')->group(function () {
    Route::get('/', [PassengerApiController::class, 'index']);         // Get all passengers
    Route::post('/', [PassengerApiController::class, 'store']);        // Create new passenger
    Route::get('/{id}', [PassengerApiController::class, 'show']);      // Get passenger by id
    Route::put('/{id}', [PassengerApiController::class, 'update']);    // Update passenger
    Route::delete('/{id}', [PassengerApiController::class, 'destroy']); // Delete passenger
});
