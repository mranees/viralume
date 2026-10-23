<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('doctors', DoctorController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('specializations', SpecializationController::class);
});

require __DIR__.'/settings.php';
