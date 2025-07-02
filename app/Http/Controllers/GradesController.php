<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display the grades view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('grades');
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
            // Validate the request
            $validated = $request->validate([
                'courseCode' => 'required|string|max:20',
                'courseName' => 'required|string|max:255',
                'units' => 'required|integer|min:1|max:10',
                'grade' => 'required|string|in:A,A-,B+,B,B-,C+,C,C-,D+,D,F,INC,W'
            ]);

            try {
                // Create course logic here
                // Example: Course::create($validated);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Course added successfully!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding course: ' . $e->getMessage()
                ], 500);
            }
        }
}