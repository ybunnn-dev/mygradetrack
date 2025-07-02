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

        // Now it's safe to query courses
        $courses = DB::table('courses')
            ->join('semesters', 'courses.semester_id', '=', 'semesters.id')
            ->where('semesters.student_id', $userId)
            ->select(
                'courses.id',
                'courses.course_name',
                'courses.units',
                'courses.grade',
                'courses.remarks',
                'courses.semester_id',
                'semesters.semester',
                'semesters.start_year',
                'semesters.end_year'
            )
            ->orderBy('semesters.start_year')
            ->orderByRaw("FIELD(semesters.semester, 'First Semester', 'Second Semester')")
            ->get();

        $sortedSemesters = collect($semesterBreakdown)->sortBy([
            fn ($s) => $s['start_year'],
            fn ($s) => match(strtolower($s['semester'])) {
                '1st sem', 'first semester' => 1,
                '2nd sem', 'second semester' => 2,
                default => 3,
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