<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
Route::get('/', function () {
    return view('welcome');
});


Route::put('passengers/restore/{id}', [PassengerController::class, 'restore'])->name('passengers.restore');


Route::get('passengers/search', [PassengerController::class, 'search'])->name('passengers.search');


Route::resource('passengers', PassengerController::class);


Route::resource('flights', FlightController::class);
Route::put('flights/restore/{id}', [FlightController::class, 'restore'])->name('flights.restore');
Route::get('flights/{flight}/passengers', [FlightController::class, 'showPassengers'])->name('flights.passengers');
