<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightApiController;
use App\Http\Controllers\PassengerApiController;
use App\Http\Controllers\AuthApiController;

Route::middleware('security.headers')->group(function () {

    Route::get('flights/export', [FlightApiController::class, 'export']);
    Route::get('/passengers/export', [PassengerApiController::class, 'export']);

    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('login', [AuthApiController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthApiController::class, 'logout']);

    Route::apiResource('passengers', PassengerApiController::class);
    Route::apiResource('flights', FlightApiController::class);

    Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin', function () {
        return response()->json(['message' => 'Welcome Admin!']);
    });

    // Any other routes with security.headers
    Route::get('/adminss', function () {
        return 'Admin page with security headers';
    });

});
