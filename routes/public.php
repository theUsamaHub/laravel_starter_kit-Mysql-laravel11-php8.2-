<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Public-facing routes that don't require authentication.
| These are separate from web.php to keep concerns clean.
|
*/

Route::get('/about', function () {
    return view('public.about');
})->name('public.about');

Route::get('/services', function () {
    return view('public.services');
})->name('public.services');

Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');

Route::post('/subscribe', [\App\Http\Controllers\SubscriberController::class, 'store'])->name('public.subscribe');
