<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::to('testmailproject0011@gmail.com')->send(new TestMail());
    return 'Test email sent! Check your inbox.';
});
Route::get('/', function () {
    return response()->json(['message' => 'Laravel web route working']);
});

Route::get('/test-flight-reminder', function () {
    Artisan::call('email:flight-reminder');
    return 'Flight reminder emails have been sent (if any)!';
});