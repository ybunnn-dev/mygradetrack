<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'email_verified_at' => null,
            'password' => Hash::make('password'), // Using a default password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'remember_token' => null,
            'current_team_id' => null,
            'profile_photo_path' => null,
            'created_at' => '2025-06-28 14:02:56',
            'updated_at' => '2025-07-03 02:18:15',
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
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-01 09:29:24',
            ],
            [
                'id' => 2,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2022,
                'end_year' => 2023,
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-01 09:29:39',
            ],
            [
                'id' => 3,
                'student_id' => 1,
                'semester' => '1st Sem',
                'start_year' => 2023,
                'end_year' => 2024,
                'created_at' => '2025-07-01 09:50:22',
                'updated_at' => '2025-07-01 09:50:22',
            ],
            [
                'id' => 4,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2023,
                'end_year' => 2024,
                'created_at' => '2025-07-01 09:50:22',
                'updated_at' => '2025-07-01 09:50:22',
            ],
            [
                'id' => 5,
                'student_id' => 1,
                'semester' => '1st Sem',
                'start_year' => 2024,
                'end_year' => 2025,
                'created_at' => '2025-07-01 09:50:22',
                'updated_at' => '2025-07-01 09:50:22',
            ],
            [
                'id' => 6,
                'student_id' => 1,
                'semester' => '2nd Sem',
                'start_year' => 2024,
                'end_year' => 2025,
                'created_at' => '2025-07-01 09:50:22',
                'updated_at' => '2025-07-01 09:50:22',
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
                'course_code' => 'GEC 11',
                'semester_id' => 1,
                'course_name' => 'Understanding the Self',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-03 06:58:14',
            ],
            [
                'id' => 2,
                'course_code' => 'GEC 14',
                'semester_id' => 1,
                'course_name' => 'Mathematics in the Modern World',
                'units' => 3,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-03 06:59:49',
            ],
            [
                'id' => 3,
                'course_code' => 'IT 101',
                'semester_id' => 1,
                'course_name' => 'Introduction to Computing',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-03 07:09:10',
            ],
            [
                'id' => 4,
                'course_code' => 'IT 102',
                'semester_id' => 1,
                'course_name' => 'Computer Programming 1',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-01 09:29:24',
            ],
            [
                'id' => 5,
                'course_code' => 'PATHFIT 1',
                'semester_id' => 1,
                'course_name' => 'Movement Competency Training',
                'units' => 2,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-03 07:07:43',
            ],
            [
                'id' => 6,
                'course_code' => 'PHYS1',
                'semester_id' => 1,
                'course_name' => 'Physics for Computing',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:24',
                'updated_at' => '2025-07-03 07:07:27',
            ],
            
            // Second Semester 2022-2023
            [
                'id' => 7,
                'course_code' => 'GEC 15',
                'semester_id' => 2,
                'course_name' => 'Purposive Communication',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-03 07:08:26',
            ],
            [
                'id' => 8,
                'course_code' => 'GEC ELECT 21.1',
                'semester_id' => 2,
                'course_name' => 'Environmental Science',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-03 07:08:47',
            ],
            [
                'id' => 9,
                'course_code' => 'IT 103',
                'semester_id' => 2,
                'course_name' => 'Computer Programming 2',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-03 07:08:57',
            ],
            [
                'id' => 10,
                'course_code' => 'IT 107',
                'semester_id' => 2,
                'course_name' => 'Digital Systems Design',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-01 09:29:39',
            ],
            [
                'id' => 11,
                'course_code' => 'IT 109',
                'semester_id' => 2,
                'course_name' => 'Discrete Mathematics',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-01 09:29:39',
            ],
            [
                'id' => 12,
                'course_code' => 'PATHFIT 2',
                'semester_id' => 2,
                'course_name' => 'Exercise-based Fitness Activities',
                'units' => 2,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:29:39',
                'updated_at' => '2025-07-01 09:29:39',
            ],
            
            // First Semester 2023-2024
            [
                'id' => 13,
                'course_code' => 'GEC 13',
                'semester_id' => 3,
                'course_name' => 'The Contemporary World',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 14,
                'course_code' => 'GEC 16',
                'semester_id' => 3,
                'course_name' => 'The Entrepreneurial Mind',
                'units' => 3,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 15,
                'course_code' => 'IT 110',
                'semester_id' => 3,
                'course_name' => 'Data Structures and Algorithm',
                'units' => 3,
                'grade' => 2.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 16,
                'course_code' => 'IT 111',
                'semester_id' => 3,
                'course_name' => 'Object Oriented Programming',
                'units' => 3,
                'grade' => 1.7,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 17,
                'course_code' => 'IT 112',
                'semester_id' => 3,
                'course_name' => 'Introduction to Human Computer Interaction',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 18,
                'course_code' => 'IT 113',
                'semester_id' => 3,
                'course_name' => 'Platform Technologies',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            [
                'id' => 19,
                'course_code' => 'PATHFIT 3',
                'semester_id' => 3,
                'course_name' => 'PATHFit 3',
                'units' => 2,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:14',
                'updated_at' => '2025-07-01 09:51:14',
            ],
            
            // Second Semester 2023-2024
            [
                'id' => 20,
                'course_code' => 'GEC 17',
                'semester_id' => 4,
                'course_name' => 'Science, Technology and Society',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 21,
                'course_code' => 'GEC 18',
                'semester_id' => 4,
                'course_name' => 'Ethics',
                'units' => 3,
                'grade' => 1.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 22,
                'course_code' => 'GEC ELECT 22.1',
                'semester_id' => 4,
                'course_name' => 'Human Reproduction',
                'units' => 3,
                'grade' => 1.7,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 23,
                'course_code' => 'IT 114',
                'semester_id' => 4,
                'course_name' => 'Information Management I',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 24,
                'course_code' => 'IT 115',
                'semester_id' => 4,
                'course_name' => 'Web Systems and Technologies',
                'units' => 3,
                'grade' => 1.9,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 25,
                'course_code' => 'IT 116',
                'semester_id' => 4,
                'course_name' => 'Special Topics in IT',
                'units' => 1,
                'grade' => 1.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 26,
                'course_code' => 'IT 117',
                'semester_id' => 4,
                'course_name' => 'Networking 1',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            [
                'id' => 27,
                'course_code' => 'PATHFIT 4',
                'semester_id' => 4,
                'course_name' => 'PATHFit 4',
                'units' => 2,
                'grade' => 1.2,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:51:38',
                'updated_at' => '2025-07-01 09:51:38',
            ],
            
            // First Semester 2024-2025
            [
                'id' => 28,
                'course_code' => 'GEC 19',
                'semester_id' => 5,
                'course_name' => 'Art Appreciation',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 29,
                'course_code' => 'GEC ELECT 23.1',
                'semester_id' => 5,
                'course_name' => 'Living in the IT Era [2]',
                'units' => 3,
                'grade' => 2.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 30,
                'course_code' => 'IT 118',
                'semester_id' => 5,
                'course_name' => 'Networking 2',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 31,
                'course_code' => 'IT 119',
                'semester_id' => 5,
                'course_name' => 'Information Management 2',
                'units' => 3,
                'grade' => 2.1,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 32,
                'course_code' => 'IT 120',
                'semester_id' => 5,
                'course_name' => 'Quantitative Methods',
                'units' => 3,
                'grade' => 2.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 33,
                'course_code' => 'IT 121',
                'semester_id' => 5,
                'course_name' => 'Systems Integration and Architecture 1',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            [
                'id' => 34,
                'course_code' => 'IT 122',
                'semester_id' => 5,
                'course_name' => 'Web Development',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:08',
                'updated_at' => '2025-07-01 09:52:08',
            ],
            
            // Second Semester 2024-2025
            [
                'id' => 35,
                'course_code' => 'IT ELECT 2',
                'semester_id' => 6,
                'course_name' => 'Big Data Analysis',
                'units' => 3,
                'grade' => 1.6,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 07:45:25',
            ],
            [
                'id' => 36,
                'course_code' => 'IT 106',
                'semester_id' => 6,
                'course_name' => 'Application Development and Emerging Technologies',
                'units' => 3,
                'grade' => 1.5,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 07:45:53',
            ],
            [
                'id' => 37,
                'course_code' => 'IT 119',
                'semester_id' => 6,
                'course_name' => 'Information Assurance Security 1',
                'units' => 3,
                'grade' => 1.3,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 07:45:40',
            ],
            [
                'id' => 38,
                'course_code' => 'IT 120',
                'semester_id' => 6,
                'course_name' => 'Event Driven Programming',
                'units' => 3,
                'grade' => 1.0,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 19:33:38',
            ],
            [
                'id' => 39,
                'course_code' => 'IT 121',
                'semester_id' => 6,
                'course_name' => 'Capstone Project 1',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 07:44:30',
            ],
            [
                'id' => 40,
                'course_code' => 'IT ELECT 3',
                'semester_id' => 6,
                'course_name' => 'E-Commerce',
                'units' => 3,
                'grade' => 1.4,
                'remarks' => 'Passed',
                'created_at' => '2025-07-01 09:52:30',
                'updated_at' => '2025-07-03 07:45:15',
            ],
            [
                'id' => 41,
                'course_code' => 'GEC 12',
                'semester_id' => 6,
                'course_name' => 'Readings in Philippine History',
                'units' => 3,
                'grade' => 1.8,
                'remarks' => 'Passed',
                'created_at' => '2025-07-03 07:36:05',
                'updated_at' => '2025-07-03 07:36:05',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}