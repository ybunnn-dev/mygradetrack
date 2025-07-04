<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\MetricsController;

Route::get('/', function () {
    return view('welcome');
});

//  Protect everything after login
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/grades', [GradesController::class, 'index'])->name('grades');
    Route::post('/semesters', [GradesController::class, 'storeSemester'])->name('semesters.store');
    Route::post('/store-course', [GradesController::class, 'storeCourse'])->name('courses.store');
    Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');
    Route::get('/semesters/{semester}/courses', [GradesController::class, 'getCourses']);
    Route::get('/edit-course', [GradesController::class, 'getUserCourses']);

    Route::put('/courses/{id}', [GradesController::class, 'updateCourse'])->name('courses.update');
});
