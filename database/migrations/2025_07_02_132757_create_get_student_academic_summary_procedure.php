<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS GetStudentAcademicSummary;

            CREATE PROCEDURE GetStudentAcademicSummary(IN student_id INT)
            BEGIN
                SELECT 
                    SUM(c.grade * c.units) / SUM(c.units) AS overall_gwa,
                    COUNT(DISTINCT s.id) AS total_semesters,
                    COUNT(c.id) AS total_courses
                FROM semesters s
                JOIN courses c ON s.id = c.semester_id
                WHERE s.student_id = student_id;

                SELECT 
                    s.id AS semester_id,
                    s.semester,
                    s.start_year,
                    s.end_year,
                    SUM(c.grade * c.units) / SUM(c.units) AS semester_gwa,
                    COUNT(c.id) AS courses_count,
                    SUM(c.units) AS total_units
                FROM semesters s
                JOIN courses c ON s.id = c.semester_id
                WHERE s.student_id = student_id
                GROUP BY s.id, s.semester, s.start_year, s.end_year
                ORDER BY s.start_year, 
                    CASE s.semester 
                        WHEN 'First Semester' THEN 1
                        WHEN 'Second Semester' THEN 2
                        ELSE 3
                    END;
            END;
        ");

    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetStudentAcademicSummary;");
    }
};
