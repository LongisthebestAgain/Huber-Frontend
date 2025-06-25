<?php

use Illuminate\Support\Facades\Route;

// Main pages
Route::get('/', function () {
    return view('index');
})->name('home');

// Authentication routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// User related routes
Route::get('/profile', function () {
    return view('user-profile');
})->name('user.profile');

Route::get('/driver/profile', function () {
    return view('driver-profile');
})->name('driver.profile');

// Booking and ride related routes
Route::get('/bookings', function () {
    return view('user-bookings');
})->name('user.bookings');

Route::get('/history', function () {
    return view('user-history');
})->name('user.history');

Route::get('/rides', function () {
    return view('rides');
})->name('rides');

Route::get('/seat-selection', function () {
    return view('seat-selection');
})->name('seat.selection');

Route::get('/payment', function () {
    return view('payment');
})->name('payment');
