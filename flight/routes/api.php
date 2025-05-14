<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightApiController;
use App\Http\Controllers\PassengerApiController;
use App\Http\Controllers\AuthApiController;
use App\Http\Middleware\RoleMiddleware; 

Route::post('register', [AuthApiController::class, 'register']);
Route::post('login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthApiController::class, 'logout']);

Route::apiResource('passengers', PassengerApiController::class);
Route::apiResource('flights', FlightApiController::class);

Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin', function () {
    return response()->json(['message' => 'Welcome Admin!']);
});
