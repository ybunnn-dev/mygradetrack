<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\MetricsController;
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
    Route::post('/semesters', [GradesController::class, 'storeSemester'])->name('semesters.store');
    Route::post('/store-course', [GradesController::class, 'storeCourse'])->name('courses.store');
    Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');
    Route::get('/semesters/{semester}/courses', [GradesController::class, 'getCourses']);
    Route::get('/edit-course', [GradesController::class, 'getUserCourses']);

    Route::put('/courses/{id}', [GradesController::class, 'updateCourse'])->name('courses.update');
});


Route::get('/laravel-log', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!file_exists($logPath)) {
        return 'Log file does not exist.';
    }

    return nl2br(e(file_get_contents($logPath)));
});

Route::get('/vuln', function (Request $request) {
    $id = $request->input('id');
    $results = DB::select("SELECT * FROM courses WHERE id = $id"); // ⚠️ Unsafe raw SQL
    return response()->json($results);
});


Route::view('/vuln-login', 'vuln-login'); // shows the login form

Route::post('/vuln-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    // ❗️ VULNERABLE (for testing only)
    $result = DB::select("SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1");
    
    if ($result) {
        return "Logged in as: " . $result[0]->name;
    } else {
        return "Login failed.";
    }
});
