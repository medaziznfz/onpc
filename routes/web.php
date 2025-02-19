<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes group
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // yodkhel ken e super admin
    Route::get('/special', function () {
        return view('special'); // Create this view if needed
    })->middleware('can:super-admin')->name('special');

    // yodkher e service o super admin
    Route::get('/service', function () {
        return view('special'); // Create this view if needed
    })->middleware('can:service')->name('service');
});

// Authentication routes (login/register/password reset)
require __DIR__.'/auth.php';