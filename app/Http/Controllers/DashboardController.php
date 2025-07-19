<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO; // Add this import at the top

class DashboardController extends Controller
{
   public function index()
    {
        $userId = Auth::id();

        // Get the raw PDO connection
        $pdo = DB::connection()->getPdo();

        // Call stored procedure
        $stmt = $pdo->prepare("CALL GetStudentAcademicSummary(?)");
        $stmt->execute([$userId]);

        // First result set: overall summary
        $overallSummary = $stmt->fetch(PDO::FETCH_ASSOC);

        // Second result set: semester breakdown
        $semesterBreakdown = [];
        if ($stmt->nextRowset()) {
            $semesterBreakdown = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ✅ Very important: close the cursor before making any new query
        $stmt->closeCursor();

      $courses = \App\Models\Course::with('semesters')
        ->whereHas('semesters', fn($query) => $query->where('student_id', $userId))
        ->get()
        ->sortBy([
            fn($course) => $course->semesters->start_year,
            fn($course) => match(strtolower($course->semesters->semester)) {
                'first semester' => 1,
                'second semester' => 2,
                default => 3,
            },
        ])
        ->values()
        ->map(function ($course) {
            return [
                'id' => $course->id,
                'course_name' => $course->course_name,
                'units' => $course->units,
                'grade' => $course->grade,
                'remarks' => $course->remarks,
                'semester_id' => $course->semester_id,
                'semester' => $course->semesters->semester ?? null,
                'start_year' => $course->semesters->start_year ?? null,
                'end_year' => $course->semesters->end_year ?? null,
            ];
        });


        $sortedSemesters = collect($semesterBreakdown)->sortBy([
            fn ($s) => $s['start_year'], // ascending (older first)
            fn ($s) => match(strtolower($s['semester'])) {
                '1st sem', 'first semester' => 1,
                '2nd sem', 'second semester' => 2,
                default => 3, // summer or any unknown
            },
        ])->values();

        // Separate arrays for labels and units
        $unitSemesters = $sortedSemesters->map(fn($s) => "{$s['semester']} {$s['start_year']}-{$s['end_year']}");
        $unitsData = $sortedSemesters->pluck('total_units');

        return view('dashboard', [
            'overall' => $overallSummary ?: null,
            'semesters' => $semesterBreakdown,
            'courses' => $courses,
            'sortedSemesters' => $sortedSemesters,
            'unitSemesters' => $unitSemesters,
            'unitsData' => $unitsData,
        ]);
    }
}