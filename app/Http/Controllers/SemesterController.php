<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function storeSemester(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|string|in:1st,2nd,Midyear',
            'yearStart' => 'required|integer|min:2000|max:2100',
            'yearEnd' => 'required|integer'
        ]);

        try {
            // Get current user's student_id — update this if your relationship is different
            $studentId = auth()->id(); // or: auth()->user()->student->id

            $validated['student_id'] = $studentId;

            $semester = Semester::create([
                'semester'   => $validated['semester'],
                'start_year' => $validated['yearStart'],
                'end_year'   => $validated['yearEnd'],
                'student_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Semester added successfully!',
                'semester' => $semester
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding semester: ' . $e->getMessage()
            ], 500);
        }
    }

}