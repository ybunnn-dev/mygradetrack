<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class SemesterController extends Controller
{
    public function storeSemester(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|string|in:1st Sem,2nd Sem,Midyear',
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

    /**
     * Display the specified semester
     */
    public function show($id): JsonResponse
    {
        Log::info('Show semester called with ID: ' . $id);
        
        try {
            $semester = Semester::where('id', $id)
                              ->where('student_id', auth()->id()) // Ensure user can only access their own semesters
                              ->firstOrFail();
            
            Log::info('Semester found: ', $semester->toArray());
            
            return response()->json([
                'success' => true,
                'semester' => $semester->semester,
                'start_year' => $semester->start_year,
                'end_year' => $semester->end_year
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching semester: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Semester not found or access denied'
            ], 404);
        }
    }

    /**
     * Update the specified semester
     */
    public function update(Request $request, $id): JsonResponse
    {
        Log::info('Update semester called with ID: ' . $id);
        Log::info('Request data: ', $request->all());
        
        try {
            $semester = Semester::where('id', $id)
                              ->where('student_id', auth()->id()) // Ensure user can only update their own semesters
                              ->firstOrFail();
            
            Log::info('Semester found for update: ', $semester->toArray());
            
            $validated = $request->validate([
                'semester' => 'required|string|in:1st,2nd,Midyear',
                'yearStart' => 'required|integer|min:2000|max:2100',
                'yearEnd' => 'required|integer|min:2000|max:2100'
            ]);

            Log::info('Validation passed: ', $validated);

            // Validate that yearEnd is exactly yearStart + 1 (optional - remove if not needed)
            if ($validated['yearEnd'] !== $validated['yearStart'] + 1) {
                Log::warning('Year validation failed: yearEnd should be yearStart + 1');
                return response()->json([
                    'success' => false,
                    'message' => 'End year must be exactly one year after start year'
                ], 422);
            }

            $semester->update([
                'semester' => $validated['semester'],
                'start_year' => $validated['yearStart'],
                'end_year' => $validated['yearEnd']
            ]);

            Log::info('Semester updated successfully: ', $semester->fresh()->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Semester updated successfully',
                'semester' => $semester->semester,
                'yearStart' => $semester->start_year,
                'yearEnd' => $semester->end_year
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation error: ', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update semester or access denied'
            ], 500);
        }
    }

    /**
     * Remove the specified semester from storage
     */
    public function destroy($id): JsonResponse
    {
        Log::info('Delete semester called with ID: ' . $id);
        
        try {
            $semester = Semester::where('id', $id)
                              ->where('student_id', auth()->id()) // Ensure user can only delete their own semesters
                              ->firstOrFail();
            
            Log::info('Semester found for deletion: ', $semester->toArray());
            
            // Delete associated courses first (if you have foreign key constraints)
            // $semester->courses()->delete();
            
            $semester->delete();

            Log::info('Semester deleted successfully with ID: ' . $id);

            return response()->json([
                'success' => true,
                'message' => 'Semester deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete semester or access denied'
            ], 500);
        }
    }
}