<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Course;
use App\Models\User;

class GradesController extends Controller
{
    /**
     * Display the grades view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        $semesters = $user->semesters()
            ->with(['courses' => function($query) {
                $query->whereNotNull('grade');
            }])
            ->get()
            ->each(function ($semester) {
                $totalWeightedGrade = 0;
                $totalUnits = 0;
                
                foreach ($semester->courses as $course) {
                    $totalWeightedGrade += $course->grade * $course->units;
                    $totalUnits += $course->units;
                }
                
                $semester->gwa = $totalUnits > 0 ? round($totalWeightedGrade / $totalUnits, 2) : null;
            });

        return view('grades', compact('semesters'));
    }
    public function getCourses(Semester $semester)
    {
        return response()->json([
            'semester' => $semester,
            'courses' => $semester->courses
        ]);
    }
    public function storeSemester(Request $request)
        {
            // Validate the request
            $validated = $request->validate([
                'semester' => 'required|string|in:1st,2nd,midyear',
                'yearStart' => 'required|integer|min:2000|max:2100',
                'yearEnd' => 'required|integer'
            ]);

            try {
                // Create semester logic here
                // Example: Semester::create($validated);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Semester added successfully!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding semester: ' . $e->getMessage()
                ], 500);
            }
        }
      public function storeCourse(Request $request)
        {
            $validated = $request->validate([
                'courseCode' => 'required|string|max:20',
                'courseName' => 'required|string|max:255',
                'units' => 'required|integer|min:1|max:10',
                'grade' => 'required|numeric|min:1|max:5',
                'semester_id' => 'required|exists:semesters,id',
            ]);

            $remark = $validated['grade'] <= 3.0 ? 'Passed' : 'Failed';

            $course = new Course();
            $course->semester_id = $validated['semester_id'];
            $course->course_code = $validated['courseCode'];
            $course->course_name = $validated['courseName'];
            $course->units = $validated['units'];
            $course->grade = $validated['grade'];
            $course->remarks = $remark;
            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Course added successfully!',
                'course' => $course
            ]);
        }

        public function getUserCourses()
        {
            $user = Auth::user();
            
            // Get all semesters with their courses for the authenticated user
            $semesters = $user->semesters()
                ->with(['courses' => function($query) {
                    $query->select('id', 'semester_id', 'course_code as courseCode', 'course_name', 'units', 'grade');
                }])
                ->get(['id', 'semester', 'start_year', 'end_year']);

            // Transform data into { semesterId: [courses] } format
            $coursesBySemester = [];
            foreach ($semesters as $semester) {
                $coursesBySemester[$semester->id] = $semester->courses;
            }

            return response()->json([
                'success' => true,
                'semesters' => $semesters,
                'courses' => $coursesBySemester
            ]);
        }

        public function updateCourse(Request $request, $id)
        {
            $validated = $request->validate([
                'courseCode' => 'required|string|max:20',
                'courseName' => 'required|string|max:255',
                'units' => 'required|integer|min:1|max:10',
                'grade' => 'required|numeric|min:1|max:5',
            ]);

            try {
                \Log::info('Course Code:', ['courseCode' => $validated['courseCode']]);
                $course = Course::findOrFail($id);
                $course->update([
                    'course_code' => $validated['courseCode'],
                    'course_name' => $validated['courseName'],
                    'units' => $validated['units'],
                    'grade' => $validated['grade'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Course updated successfully!',
                    'course' => $course
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating course: ' . $e->getMessage()
                ], 500);
            }
        }

}