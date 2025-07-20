<div 
    x-data="addCourseModal()" 
    @open-add-course.window="open = true" 
    x-show="open" 
    x-cloak 
    class="relative z-50" 
    aria-labelledby="dialog-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Backdrop (same as before) -->
    <div 
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50"
        @click="open = false"
    ></div>

    <!-- Modal content -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full mx-4 sm:mx-auto sm:w-4/5 md:w-3/5 lg:w-2/5 xl:w-1/4 max-w-md transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all"
            @click.stop
        >
            <form @submit.prevent="submit">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4 text-center" id="dialog-title">
                        Add New Course
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label for="courseCode" class="block text-sm font-medium text-gray-700 mb-1">
                                Course Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="courseCode" x-model="courseCode" required maxlength="20" placeholder="e.g., CS101" class="block w-full rounded-md border border-gray-300 py-2 px-3 text-sm uppercase shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="courseName" class="block text-sm font-medium text-gray-700 mb-1">
                                Course Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="courseName" x-model="courseName" required maxlength="255" placeholder="e.g., Introduction to Programming" class="block w-full rounded-md border border-gray-300 py-2 px-3 text-sm shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="units" class="block text-sm font-medium text-gray-700 mb-1">
                                Units <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="units" x-model="units" required min="1" max="10" placeholder="e.g., 3" class="block w-full rounded-md border border-gray-300 py-2 px-3 text-sm shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none">
                        </div>

                        <div>
                            <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">
                                Grade <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="grade" 
                                x-model="grade" 
                                required 
                                step="0.1" 
                                min="1.0" 
                                max="4.0" 
                                placeholder="e.g., 3.5" 
                                class="block w-full rounded-md border border-gray-300 py-2 px-3 text-sm shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none"
                            >
                            <p class="mt-1 text-xs text-gray-500">Enter a value between 1.0 and 4.0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end sm:gap-3">
                    <button 
                        type="button" 
                        @click="open = false"
                        class="w-full inline-flex justify-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-colors duration-200 sm:w-auto"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button"
                        @click="submit"
                        class="w-full inline-flex justify-center rounded-md bg-navgreen px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition-colors focus:ring-2 focus:ring-green-600 focus:ring-offset-2 sm:w-auto"
                    >
                        Add Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
