<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::put('passengers/restore/{id}', [PassengerController::class, 'restore'])->name('passengers.restore');
Route::get('passengers/search', [PassengerController::class, 'search'])->name('passengers.search');
Route::resource('passengers', PassengerController::class);

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::resource('flights', FlightController::class);
    Route::put('flights/restore/{id}', [FlightController::class, 'restore'])->name('flights.restore');
    Route::get('flights/{flight}/passengers', [FlightController::class, 'showPassengers'])->name('flights.passengers');
});


Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('flightslist', [AuthController::class, 'listFlights'])->name('flights.list');
Route::post('flights/{id}/book', [AuthController::class, 'bookFlight'])->name('flights.book');
Route::delete('/flights/{flight}/passengers/{passenger}', [FlightController::class, 'removePassenger'])->name('flights.passengers.remove');
Route::get('/passenger/flights', [AuthController::class, 'showFlightsForPassenger'])->name('passenger.flights');


