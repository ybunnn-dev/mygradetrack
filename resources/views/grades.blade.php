<x-app-layout>
    @section('title', 'Grades')
    <div class="min-h-screen bg-mainback flex flex-col">
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 py-8 sm:py-10 lg:py-12">
                <!-- Responsive heading -->
                <h1 class="font-bold mb-6 text-xl sm:text-base md:text-2xl lg:text-3xl text-text_heavy">
                    Grades
                </h1>

                <!-- Two-column layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 min-h-[80vh] h-[80dvh]">
                    <!-- Semesters Card (Left Side) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg p-6 sm:p-8 lg:p-10 h-full overflow-y-auto flex flex-col">
                            <div class="flex justify-between items-center mb-3 sm:mb-4">
                                <h2 class="text-base sm:text-lg font-semibold text-text_heavy">Semesters</h2>
                                <button 
                                   onclick="window.dispatchEvent(new CustomEvent('open-add-semester'))"
                                    class="bg-navgreen hover:bg-green-700 text-white p-1 sm:p-1.5 rounded text-[10px] xs:text-xs font-medium transition-colors duration-200 flex items-center gap-1"
                                >
                                    <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Semester
                                </button>
                            </div>
                            <div class="space-y-2 sm:space-y-3 flex-1" id="semesters-list">
                                <!-- Sample Semester Items -->
                                <div 
                                    class="p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition semester-item"
                                    data-semester="1"
                                    onclick="loadSemesterGrades(1)"
                                >
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="text-sm sm:text-base font-medium">1st Semester</div>
                                            <div class="text-xs text-gray-500">2023-2024</div>
                                        </div>
                                        <span class="text-xs sm:text-sm bg-green-100 text-green-800 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded">GPA: 3.75</span>
                                    </div>
                                </div>
                                <div 
                                    class="p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition semester-item"
                                    data-semester="2"
                                    onclick="loadSemesterGrades(2)"
                                >
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="text-sm sm:text-base font-medium">2nd Semester</div>
                                            <div class="text-xs text-gray-500">2023-2024</div>
                                        </div>
                                        <span class="text-xs sm:text-sm bg-green-100 text-green-800 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded">GPA: 3.92</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grades Table Card (Right Side) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg p-6 sm:p-8 lg:p-10 h-full overflow-y-auto flex flex-col">
                            <div class="flex justify-between items-center mb-3 sm:mb-4">
                                <h2 class="text-base sm:text-lg font-semibold text-text_heavy">Grades for <span id="current-semester">1st Semester 2023-2024</span></h2>
                                <button 
                                    onclick="window.dispatchEvent(new CustomEvent('open-add-course'))"
                                    class="bg-navgreen hover:bg-green-700 text-white p-1 sm:p-1.5 rounded text-[10px] xs:text-xs font-medium transition-colors duration-200 flex items-center gap-1"
                                >
                                    <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Course
                                </button>
                            </div>
                            <div class="overflow-x-auto flex-1">
                                <table class="min-w-full table-fixed divide-y divide-gray-200">
                                    <colgroup>
                                    <col class="w-1/6" />
                                    <col class="w-2/6" />
                                    <col class="w-1/15" />
                                    <col class="w-1/5" />
                                    <col class="w-1/6" />
                                    <col class="w-1/6" />
                                    </colgroup>
                                    <thead class="bg-gray-50 text-[0.625rem] font-medium text-text_semi uppercase tracking-wide">
                                    <tr>
                                        <th class="py-2 text-left">Code</th>
                                        <th class="py-2 text-left">Course Name</th>
                                        <th class="py-2 text-center">Units</th>
                                        <th class="py-2 text-center">Grade</th>
                                        <th class="py-2 text-left">Remarks</th>
                                        <th class="py-2 text-left">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 text-xs font-medium text-text_light" id="grades-table-body">
                                    <tr>
                                        <td class="py-2 truncate text-left">CS101</td>
                                        <td class="py-2 break-words text-left">Introduction to Programming</td>
                                        <td class="py-2 text-center">3</td>
                                        <td class="py-2 text-center">A</td>
                                        <td class="py-2 text-left text-green-600">Passed</td>
                                        <td class="py-2 text-left">
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <button onclick="editCourse(1)" class="text-blue-600 hover:text-blue-900 text-[0.6875rem]">Edit</button>
                                            <button onclick="deleteCourse(1)" class="text-red-600 hover:text-red-900 text-[0.6875rem]">Delete</button>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 truncate text-left">MATH101</td>
                                        <td class="py-2 break-words text-left">Calculus I</td>
                                        <td class="py-2 text-center">4</td>
                                        <td class="py-2 text-center">B+</td>
                                        <td class="py-2 text-left text-green-600">Passed</td>
                                        <td class="py-2 text-left">
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <button onclick="editCourse(2)" class="text-blue-600 hover:text-blue-900 text-[0.6875rem]">Edit</button>
                                            <button onclick="deleteCourse(2)" class="text-red-600 hover:text-red-900 text-[0.6875rem]">Delete</button>
                                        </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modal Components -->
    <x-modals.add-semester-modal />
    <x-modals.add-course-modal />
    @push('scripts')
        <script src="{{ asset('js/grades.js') }}" defer></script>
    @endpush
        
</x-app-layout>
