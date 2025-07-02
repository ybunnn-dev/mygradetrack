<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\MetricsController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// If you want it protected by auth:
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // ... other routes ...
    Route::get('/grades', [GradesController::class, 'index'])->name('grades');
});
Route::post('/semesters', [GradesController::class, 'storeSemester'])->name('semesters.store');
Route::post('/courses', [GradesController::class, 'storeCourse'])->name('courses.store');
Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');