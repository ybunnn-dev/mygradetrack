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
                                @forelse($semesters as $semester)
                                <div 
                                    class="p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition semester-item"
                                    data-semester="{{ $semester->id }}"
                                    onclick="loadSemesterGrades({{ $semester->id }})"
                                >
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="text-sm sm:text-base font-medium">{{ $semester->semester }}{{ $semester->semester !== 'Midyear' ? 'ester' : '' }}</div>
                                            <div class="text-xs text-gray-500">{{ $semester->start_year }}-{{ $semester->end_year }}</div>
                                        </div>
                                        @if($semester->gwa)
                                        <span class="text-xs sm:text-sm px-1.5 sm:px-2 py-0.5 sm:py-1 rounded {{ $semester->gwa <= 1.75 ? 'bg-green-100 text-green-800' : ($semester->gwa <= 3.0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            GWA: {{ $semester->gwa }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="text-center text-gray-500 py-4">
                                    No semesters found. Add your first semester!
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Grades Table Card (Right Side) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg p-6 sm:p-8 lg:p-10 h-full overflow-y-auto flex flex-col">
                            <div class="flex justify-between items-center mb-3 sm:mb-4">
                                <h2 class="text-base sm:text-lg font-semibold text-text_heavy">Grades for <span id="current-semester">
                                    @if($semesters->isNotEmpty())
                                        {{ $semesters->first()->semester }} {{ $semesters->first()->start_year }}-{{ $semesters->first()->end_year }}
                                    @else
                                        No Semesters
                                    @endif
                                </span></h2>
                                <div class="flex gap-2">
                                    <button 
                                        onclick="window.dispatchEvent(new CustomEvent('open-edit-semester'))"
                                        class="border border-navgreen text-navgreen hover:bg-navgreen hover:text-white p-1 sm:p-1.5 rounded text-[10px] xs:text-xs font-medium transition-colors duration-200 flex items-center gap-1"
                                    >
                                        <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        Edit Semester
                                    </button>
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
                                        @if($semesters->isNotEmpty() && $semesters->first()->courses->isNotEmpty())
                                            @foreach($semesters->first()->courses as $course)
                                            <tr>
                                                <td class="py-2 truncate text-left">{{ $course->courseCode ?? 'N/A' }}</td>
                                                <td class="py-2 break-words text-left">{{ $course->course_name }}</td>
                                                <td class="py-2 text-center">{{ $course->units }}</td>
                                                <td class="py-2 text-center font-semibold {{ $course->grade <= 1.75 ? 'text-green-600' : ($course->grade <= 3.0 ? 'text-yellow-600' : 'text-red-600') }}">
                                                    {{ number_format($course->grade, 2) }}
                                                </td>
                                                <td class="py-2 text-left {{ $course->grade <= 3.0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $course->grade <= 3.0 ? 'Passed' : 'Failed' }}
                                                </td>
                                                <td class="py-2 text-left">
                                                    <div class="flex flex-col sm:flex-row gap-3">
                                                        <button onclick="editCourse({{ $course->id }})" class="text-blue-600 hover:text-blue-900 text-[0.6875rem]">Edit</button>
                                                        <button onclick="deleteCourse({{ $course->id }})" class="text-red-600 hover:text-red-900 text-[0.6875rem]">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="py-4 text-center text-gray-500">
                                                    @if($semesters->isEmpty())
                                                        No semesters available. Add a semester first.
                                                    @else
                                                        No courses found for this semester
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
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
    <x-modals.edit-semester-modal />
    <x-modals.add-course-modal />
    <x-modals.edit-course-modal />
    
    @push('scripts')
        <script src="{{ asset('js/grades.js') }}" defer></script>
    @endpush
</x-app-layout>