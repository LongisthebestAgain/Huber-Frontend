<?php

use Illuminate\Support\Facades\Route;

// Main pages
//http://127.0.0.1:8000/
Route::get('/', function () {
    return view('index');
})->name('home');

// Authentication routes
//http://127.0.0.1:8000/login
Route::get('/login', function () {
    return view('login');
})->name('login');

//http://127.0.0.1:8000/register
Route::get('/register', function () {
    return view('register');
})->name('register');

// User related routes
//http://127.0.0.1:8000/profile
Route::get('/profile', function () {
    return view('user-profile');
})->name('user.profile');

//http://127.0.0.1:8000/driver-profile
Route::get('/driver-profile', function () {
    return view('driver-profile');
})->name('driver.profile');

// Booking and ride related routes
//http://127.0.0.1:8000/bookings
Route::get('/bookings', function () {
    return view('user-bookings');
})->name('user.bookings');

//http://127.0.0.1:8000/history
Route::get('/history', function () {
    return view('user-history');
})->name('user.history');

//http://127.0.0.1:8000/rides
Route::get('/rides', function () {
    return view('rides');
})->name('rides');

//http://127.0.0.1:8000/seat-selection
Route::get('/seat-selection', function () {
    return view('seat-selection');
})->name('seat.selection');

//http://127.0.0.1:8000/payment
Route::get('/payment', function () {
    return view('payment');
})->name('payment');
