<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\MetricsController;
use Illuminate\Support\Facades\Artisan;

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



Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return '✅ Laravel config, cache, and views cleared.';
});


Route::get('/check-session-db', function () {
    return [
        'session_driver' => config('session.driver'),
        'session_connection' => config('session.connection'),
        'db_connection' => config('database.default'),
    ];
});