<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\SemesterController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


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
    Route::post('/semesters/add', [SemesterController::class, 'storeSemester'])->name('semesters.store');
    Route::post('/store-course', [GradesController::class, 'storeCourse'])->name('courses.store');
    Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');
    Route::get('/semesters/{semester}/courses', [GradesController::class, 'getCourses']);
    Route::get('/edit-course', [GradesController::class, 'getUserCourses']);
    Route::get('/semesters/{id}', [SemesterController::class, 'show'])->name('semesters.show');
    Route::put('/semesters/{id}', [SemesterController::class, 'update'])->name('semesters.update');
    Route::delete('/semesters/{id}', [SemesterController::class, 'destroy'])->name('semesters.destroy');
    Route::put('/courses/{id}', [GradesController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{id}', [GradesController::class, 'destroyCourse'])->name('courses.destroy');
});

