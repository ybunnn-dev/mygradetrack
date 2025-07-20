<div 
    x-data="addSemesterModal()" 
    @open-add-semester.window="open = true" 
    x-show="open" 
    x-cloak
    class="relative z-50"
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

    <!-- Modal Content -->
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
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4 text-center">
                        Add Semester
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Semester Dropdown - Now fully integrated with parent component -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Semester
                            </label>
                            
                            <button 
                                @click="dropdownOpen = !dropdownOpen" 
                                type="button"
                                class="w-full bg-white text-gray-900 border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none font-medium rounded-md text-sm px-4 py-2.5 text-left flex items-center justify-between shadow-sm"
                            >
                                <span x-text="semester || 'Select Semester'"></span>
                                <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div 
                                x-show="dropdownOpen" 
                                @click.outside="dropdownOpen = false"
                                x-transition
                                class="absolute z-10 mt-1 w-full bg-white divide-y divide-gray-100 rounded-md shadow-lg"
                            >
                                <template x-for="option in semesterOptions" :key="option">
                                    <button
                                       @click="selectSemester(option, $event)"
                                        type="button" 
                                        x-text="option"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        :class="{ 'bg-gray-100 font-semibold': semester === option }"
                                    ></button>
                                </template>
                            </div>
                        </div>
                        
                        <!-- Year Inputs (same as before) -->
                        <div>
                            <label for="year-start" class="block text-sm font-medium text-gray-700 mb-1">
                                Academic Year Start
                            </label>
                            <input 
                                type="number" 
                                id="year-start"
                                x-model="yearStart" 
                                min="2000" 
                                max="2100" 
                                required
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm"
                            >
                        </div>
                        
                        <div>
                            <label for="year-end" class="block text-sm font-medium text-gray-700 mb-1">
                                Academic Year End
                            </label>
                            <input 
                                type="text" 
                                id="year-end"
                                :value="yearEnd" 
                                disabled
                                class="block w-full rounded-md border-0 py-2 px-3 text-gray-500 bg-gray-100 shadow-sm ring-1 ring-inset ring-gray-200 sm:text-sm"
                            >
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end sm:gap-3">
                    <button 
                        @click="open = false"
                        type="button"
                        class="w-full sm:w-auto justify-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                    >
                        Cancel
                    </button>
                    
                   <button 
                        type="button"
                        x-ref="submitButton"
                        @click="confirmSubmit"
                        class="w-full sm:w-auto justify-center rounded-md bg-navgreen px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-600 focus:ring-offset-2"
                        :disabled="!semester || !yearStart"
                        :class="{ 'opacity-50 cursor-not-allowed': !semester || !yearStart }"
                    >
                        Add Semester
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>