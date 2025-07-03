<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Main pages
//http://127.0.0.1:8000/
Route::get('/', function () {
    return view('index');
})->name('home');

// Authentication routes (public)
//http://127.0.0.1:8000/login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

//http://127.0.0.1:8000/register
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Forgot password
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User related routes
    //http://127.0.0.1:8000/profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('user.profile.preferences');
    Route::post('/profile/emergency-contact', [ProfileController::class, 'updateEmergencyContact'])->name('user.profile.emergency');

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
});
