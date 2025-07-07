<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\VisitController;

// Pet routes
Route::prefix('pets')->group(function () {
    Route::get('/', [PetController::class, 'index']); // Get all pets
    Route::get('/{id}', [PetController::class, 'show']); // Get a specific pet
    Route::post('/', [PetController::class, 'store']); // Create a new pet
    Route::put('/{id}', [PetController::class, 'update']); // Update a pet
    Route::delete('/{id}', [PetController::class, 'destroy']); // Delete a pet

    // Health records for a pet
    Route::get('/{id}/health-records', [HealthRecordController::class, 'index']); // Get all health records
    Route::post('/{id}/health-records', [HealthRecordController::class, 'store']); // Add a health record

    // Visit records for a pet
    Route::get('/{id}/visits', [VisitController::class, 'index']); // Get all visit records
    Route::post('/{id}/visits', [VisitController::class, 'store']); // Add a visit record
});

// Health record routes
Route::prefix('health-records')->group(function () {
    Route::put('/{id}', [HealthRecordController::class, 'update']); // Update a health record
    Route::delete('/{id}', [HealthRecordController::class, 'destroy']); // Delete a health record
});

// Visit routes
Route::prefix('visits')->group(function () {
    Route::put('/{id}', [VisitController::class, 'update']); // Update a visit record
    Route::delete('/{id}', [VisitController::class, 'destroy']); // Delete a visit record
});