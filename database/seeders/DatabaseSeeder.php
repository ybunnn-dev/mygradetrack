<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Semester;
use App\Models\Course;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SemesterSeeder::class,
            CourseSeeder::class,
        ]);
    }
}

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Ryan Gosling',
            'email' => 'vakla123@gmail.com',
            'password' => Hash::make('password'), // You should change this
            'created_at' => '2025-06-28 22:02:56',
            'updated_at' => '2025-06-28 22:02:56',
        ]);
    }
}

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'id' => 1,
                'student_id' => 1,
                'semester' => '1st Sem',
                'start_year' => 2022,
                'end_year' => 2023,
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 2,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2022,
                'end_year' => 2023,
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 3,
                'student_id' => 1,
                'semester' => '1st Sem',
                'start_year' => 2023,
                'end_year' => 2024,
                'created_at' => '2025-07-01 17:50:22',
                'updated_at' => '2025-07-01 17:50:22',
            ],
            [
                'id' => 4,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2023,
                'end_year' => 2024,
                'created_at' => '2025-07-01 17:50:22',
                'updated_at' => '2025-07-01 17:50:22',
            ],
            [
                'id' => 5,
                'student_id' => 1,
                'semester' => '1st Sem',
                'start_year' => 2024,
                'end_year' => 2025,
                'created_at' => '2025-07-01 17:50:22',
                'updated_at' => '2025-07-01 17:50:22',
            ],
            [
                'id' => 6,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2024,
                'end_year' => 2025,
                'created_at' => '2025-07-01 17:50:22',
                'updated_at' => '2025-07-01 17:50:22',
            ],
        ];

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }
    }
}

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // First Semester 2022-2023
            [
                'id' => 1,
                'semester_id' => 1,
                'course_name' => 'GEC 11 - Understanding the Self',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 2,
                'semester_id' => 1,
                'course_name' => 'GEC 14 - Mathematics in the Modern World',
                'units' => 3,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 3,
                'semester_id' => 1,
                'course_name' => 'IT 101 - Introduction to Computing',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 4,
                'semester_id' => 1,
                'course_name' => 'IT 102 - Computer Programming 1',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 5,
                'semester_id' => 1,
                'course_name' => 'PATHFit 1 - Movement Competency Training',
                'units' => 2,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],
            [
                'id' => 6,
                'semester_id' => 1,
                'course_name' => 'Phys 1 - Physics for Computing',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:24',
                'updated_at' => '2025-07-01 17:29:24',
            ],

            // Second Semester 2022-2023
            [
                'id' => 7,
                'semester_id' => 2,
                'course_name' => 'GEC 15 - Purposive Communication',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 8,
                'semester_id' => 2,
                'course_name' => 'Gec Elect 21.1 - Environmental Science',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 9,
                'semester_id' => 2,
                'course_name' => 'IT 103 - Computer Programming 2',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 10,
                'semester_id' => 2,
                'course_name' => 'IT 107 - Digital Systems Design',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 11,
                'semester_id' => 2,
                'course_name' => 'IT 109 - Discrete Mathematics',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],
            [
                'id' => 12,
                'semester_id' => 2,
                'course_name' => 'PATHFit 2 - Exercise-based Fitness Activities',
                'units' => 2,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:29:39',
                'updated_at' => '2025-07-01 17:29:39',
            ],

            // First Semester 2023-2024
            [
                'id' => 13,
                'semester_id' => 3,
                'course_name' => 'The Contemporary World',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 14,
                'semester_id' => 3,
                'course_name' => 'The Entrepreneurial Mind',
                'units' => 3,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 15,
                'semester_id' => 3,
                'course_name' => 'Data Structures and Algorithm',
                'units' => 3,
                'grade' => 2.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 16,
                'semester_id' => 3,
                'course_name' => 'Object Oriented Programming',
                'units' => 3,
                'grade' => 1.7,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 17,
                'semester_id' => 3,
                'course_name' => 'Introduction to Human Computer Interaction',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 18,
                'semester_id' => 3,
                'course_name' => 'Platform Technologies',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],
            [
                'id' => 19,
                'semester_id' => 3,
                'course_name' => 'PATHFit 3',
                'units' => 2,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:14',
                'updated_at' => '2025-07-01 17:51:14',
            ],

            // Second Semester 2023-2024
            [
                'id' => 20,
                'semester_id' => 4,
                'course_name' => 'Science, Technology and Society',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 21,
                'semester_id' => 4,
                'course_name' => 'Ethics',
                'units' => 3,
                'grade' => 1.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 22,
                'semester_id' => 4,
                'course_name' => 'Human Reproduction',
                'units' => 3,
                'grade' => 1.7,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 23,
                'semester_id' => 4,
                'course_name' => 'Information Management I',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 24,
                'semester_id' => 4,
                'course_name' => 'Web Systems and Technologies',
                'units' => 3,
                'grade' => 1.9,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 25,
                'semester_id' => 4,
                'course_name' => 'Special Topics in IT',
                'units' => 1,
                'grade' => 1.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 26,
                'semester_id' => 4,
                'course_name' => 'Networking 1',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],
            [
                'id' => 27,
                'semester_id' => 4,
                'course_name' => 'PATHFit 4',
                'units' => 2,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:51:38',
                'updated_at' => '2025-07-01 17:51:38',
            ],

            // First Semester 2024-2025
            [
                'id' => 28,
                'semester_id' => 5,
                'course_name' => 'Art Appreciation',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 29,
                'semester_id' => 5,
                'course_name' => 'Living in the IT Era [2]',
                'units' => 3,
                'grade' => 2.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 30,
                'semester_id' => 5,
                'course_name' => 'Networking 2',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 31,
                'semester_id' => 5,
                'course_name' => 'Information Management 2',
                'units' => 3,
                'grade' => 2.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 32,
                'semester_id' => 5,
                'course_name' => 'Quantitative Methods',
                'units' => 3,
                'grade' => 2.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 33,
                'semester_id' => 5,
                'course_name' => 'Systems Integration and Architecture 1',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],
            [
                'id' => 34,
                'semester_id' => 5,
                'course_name' => 'Web Development',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:08',
                'updated_at' => '2025-07-01 17:52:08',
            ],

            // Second Semester 2024-2025
            [
                'id' => 35,
                'semester_id' => 6,
                'course_name' => 'Big Data Analysis',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
            [
                'id' => 36,
                'semester_id' => 6,
                'course_name' => 'Application Development and Emerging Technologies',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
            [
                'id' => 37,
                'semester_id' => 6,
                'course_name' => 'Information Assurance Security 1',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
            [
                'id' => 38,
                'semester_id' => 6,
                'course_name' => 'Event Driven Programming',
                'units' => 3,
                'grade' => 2.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
            [
                'id' => 39,
                'semester_id' => 6,
                'course_name' => 'Capstone Project 1',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
            [
                'id' => 40,
                'semester_id' => 6,
                'course_name' => 'E-Commerce',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 17:52:30',
                'updated_at' => '2025-07-01 17:52:30',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}