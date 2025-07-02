<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Services\AcademicSummaryService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🔹 Use service to get overall + semester GWA summary
        $summary = AcademicSummaryService::getAuthenticatedStudentSummary();

        $overallSummary = $summary['overall'] ?? null;
        $semesterBreakdown = collect($summary['semesters'] ?? []);

        // 🔹 Fetch all courses through Eloquent relationship
        $courses = $user->semesters()
            ->with('courses')
            ->get()
            ->flatMap(function ($semester) {
                return $semester->courses->map(function ($course) use ($semester) {
                    return [
                        'id' => $course->id,
                        'course_name' => $course->course_name,
                        'units' => $course->units,
                        'grade' => $course->grade,
                        'remarks' => $course->remarks,
                        'semester_id' => $semester->id,
                        'semester' => $semester->semester,
                        'start_year' => $semester->start_year,
                        'end_year' => $semester->end_year,
                    ];
                });
            });

        // 🔹 Sort semester breakdown by start year and semester name
        $sortedSemesters = $semesterBreakdown->sortBy([
            fn($s) => $s['start_year'],
            fn($s) => match(strtolower($s['semester'])) {
                '1st sem', 'first semester' => 1,
                '2nd sem', 'second semester' => 2,
                default => 3,
            },
        ])->values();

        // 🔹 Prepare chart data (labels and unit totals)
        $unitSemesters = $sortedSemesters->map(fn($s) => "{$s['semester']} {$s['start_year']}-{$s['end_year']}");
        $unitsData = $sortedSemesters->pluck('total_units');

        return view('dashboard', [
            'overall' => $overallSummary,
            'semesters' => $semesterBreakdown,
            'courses' => $courses,
            'sortedSemesters' => $sortedSemesters,
            'unitSemesters' => $unitSemesters,
            'unitsData' => $unitsData,
        ]);
    }
}
