<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AcademicSummaryService
{
    public static function getAuthenticatedStudentSummary(): array
    {
        $studentId = Auth::id();

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare('CALL GetStudentAcademicSummary(?)');
        $stmt->execute([$studentId]);

        $overall = $stmt->fetchAll();
        $stmt->nextRowset();
        $semesters = $stmt->fetchAll();

        return [
            'overall' => $overall[0] ?? null,
            'semesters' => $semesters,
        ];
    }
}
