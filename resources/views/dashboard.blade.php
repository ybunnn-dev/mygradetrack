
<x-app-layout>
    @section('title', 'Home')
    <script>
        const semesters = @json(
            $sortedSemesters->map(fn($s) => [
                $s['semester'],
                "{$s['start_year']}-{$s['end_year']}"
            ])
        );

        const gpaData = @json($sortedSemesters->pluck('semester_gwa'));

        const unitSemesters = @json($unitSemesters);
        const unitsData = @json($unitsData);

        
    </script>

    <div class="h-screen bg-mainback flex flex-col">
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 py-12">
                <!-- Responsive heading -->
                <h1 class="font-bold mb-6 text-xl sm:text-base md:text-2xl lg:text-3xl text-text_heavy">
                    Home
                </h1>
                
                <!-- ROW 1: Card Column + Honor/Graph Column -->
                <div class="flex flex-col lg:flex-row gap-3">
                    
                   <!-- Left Column: GPA / Grades / Cards -->
                    <div class="flex flex-col gap-3 w-full lg:w-1/3">
                        <!-- GPA Card -->
                        <div class="bg-f7 rounded-2xl p-4 min-h-[4rem] sm:min-h-[6rem] md:min-h-[7rem] flex items-center">
                            <div class="flex items-center gap-4 sm:gap-7 w-full pl-4 sm:pl-10">
                                <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full bg-yellow-100 flex items-center justify-center p-2">
                                    <img 
                                        src="{{ asset('images/icons/grade.svg') }}" 
                                        class="w-6 sm:w-8 md:w-10 aspect-square object-contain" 
                                        alt="GPA Icon"
                                    >
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base text-text_semi font-medium">Your Current GPA</p>
                                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-text_heavy">
                                        {{ number_format($overall['overall_gwa'] ?? 0, 4) }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Semester Card -->
                        <div class="bg-f7 rounded-2xl p-4 min-h-[4rem] sm:min-h-[6rem] md:min-h-[7rem] flex items-center">
                            <div class="flex items-center gap-4 sm:gap-7 w-full pl-4 sm:pl-10">
                                <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full bg-purple-100 flex items-center justify-center p-2">
                                    <img 
                                        src="{{ asset('images/icons/semester.svg') }}" 
                                        class="w-6 sm:w-8 md:w-10 aspect-square object-contain" 
                                        alt="Semester Icon"
                                    >
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base text-text_semi font-medium">Total Semesters</p>
                                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-text_heavy">
                                        {{ $overall['total_semesters'] ?? 0 }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Courses Card -->
                        <div class="bg-f7 rounded-2xl p-4 min-h-[4rem] sm:min-h-[6rem] md:min-h-[7rem] flex items-center">
                            <div class="flex items-center gap-4 sm:gap-7 w-full pl-4 sm:pl-10">
                                <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full bg-amber-200 flex items-center justify-center p-2">
                                    <img 
                                        src="{{ asset('images/icons/course.svg') }}" 
                                        class="w-6 sm:w-8 md:w-10 aspect-square object-contain" 
                                        alt="Courses Icon"
                                    >
                                </div>
                                <div>
                                    <p class="text-sm sm:text-base text-text_semi font-medium">Total Courses</p>
                                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-text_heavy">
                                        {{ $overall['total_courses'] ?? 0 }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Honor Message + Graph -->
                    <div class="flex flex-col gap-3 w-full lg:w-2/3">
                        <div class="pl-10 bg-white rounded-2xl p-4 min-h-[4.5rem] sm:min-h-[6rem] md:min-h-[9.8rem] flex items-center gap-4">
                            <img src="{{ asset('images/icons/award.svg') }}" alt="Academic Award" class="w-20 h-20 text-blue-500">
                           
                            <div class="flex-1">
                                <p class="text-text_semi font-medium text-sm sm:text-base mb-1">
                                    Possible Award
                                </p>
                                <h1 class="text-xl sm:text-2xl font-bold text-for_magna mb-1 text-for_magna">
                                    @php
                                        $gwa = $overall['overall_gwa'] ?? 0;
                                        if ($gwa <= 1.20) {
                                            echo 'Summa Cum Laude';
                                        } elseif ($gwa <= 1.45) {
                                            echo 'Magna Cum Laude';
                                        } elseif ($gwa <= 1.75) {
                                            echo 'Boto';
                                        } else {
                                            echo 'No Latin Honors';
                                        }
                                    @endphp
                                </h1>
                                <p class="text-text_light text-xs sm:text-sm">
                                    @if($gwa <= 1.75)
                                        You're on track! Maintain your current performance.
                                    @else
                                        Keep working hard to improve your grades.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-4 min-h-[8.5rem] sm:min-h-[9rem] md:min-h-[12rem]">
                            <canvas id="gpaChart" data-semesters="{{ json_encode($semesters ?? []) }}"></canvas>
                        </div>
                    </div>
                </div>
                               <!-- ROW 2: Table + Donut Chart -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-3">
                    <!-- Left Column: Table -->
                    <div class="bg-f7 rounded-2xl p-4 h-64 sm:h-72 md:h-80 lg:h-96 overflow-hidden p-6">
                        <!-- Table Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-text_semi text-lg">Top Courses</h3>
                        </div>
                        
                        <!-- Table Container -->
                        <div class="relative h-[calc(100%-4rem)] overflow-y-auto">
                            <table class="w-full table-fixed">
                                <!-- Table Head -->
                                <thead class="sticky top-0 bg-f7 z-10">
                                    <tr class="text-left border-b border-gray-200">
                                        <th class="pb-3 pr-4 uppercase text-xs font-semibold tracking-wider text-gray-500 w-[50%]">COURSE NAME</th>
                                        <th class="pb-3 px-2 uppercase text-xs font-semibold tracking-wider text-gray-500 text-center w-[30%]">UNITS</th>
                                        <th class="pb-3 uppercase text-xs font-semibold tracking-wider text-gray-500 text-center w-[20%]">GRADE</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($courses->sortBy('grade') as $course)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3 pr-4 text-sm font-medium text-text_semi truncate">
                                                {{ $course->course_name }}
                                            </td>
                                            <td class="py-3 px-2 text-sm text-gray-600 text-center">
                                                {{ $course->units }}
                                            </td>
                                            <td class="text-sm font-semibold text-center font-mono text-indigo-600">
                                                {{ number_format($course->grade, 1) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-3 text-center text-sm text-gray-500 italic">
                                                No courses found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                <!-- Right Column: Donut Chart -->
                    <div class="bg-f7 rounded-2xl p-6 h-64 sm:h-72 md:h-80 lg:h-96 flex flex-col">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-text_semi text-lg">Semester with Most Units</h3>
                        </div>
                        
                        <!-- Chart Container -->
                        <div class="flex-1 relative min-h-0">
                            <canvas id="unitsDonutChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        @vite(['resources/js/pages/home.js'])
    @endpush
</x-app-layout>

