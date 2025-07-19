<div 
    x-data="editSemesterModal()" 
    @open-edit-semester.window="open = true; loadSemesterData()" 
    x-show="open" 
    x-cloak 
    class="relative z-50" 
    aria-labelledby="dialog-title" 
    role="dialog" 
    aria-modal="true"
>
    <!-- Background overlay -->
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

    <!-- Modal container -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-6">
        <div 
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full mx-4 sm:mx-auto sm:w-10/12 md:w-3/4 lg:w-1/2 xl:w-1/3 max-w-xl transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all"
            @click.stop
        >
            <form @submit.prevent="submit">
                <!-- Modal content -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="w-full">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4 text-center" id="dialog-title">
                            Edit Semester
                        </h3>
                        <div class="space-y-4">
                            <!-- Semester dropdown -->
                            <div x-data="{
                                open: false,
                                selected: '',
                                options: ['1st Semester', '2nd Semester', 'Midyear'],
                                select(option) {
                                    this.selected = option;
                                    this.open = false;
                                }
                            }" class="relative">
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">
                                    Semester
                                </label>
                                <button 
                                    @click="open = !open" 
                                    type="button"
                                    class="w-full bg-white text-gray-900 border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none font-medium rounded-md text-sm px-4 py-2.5 text-left flex items-center justify-between shadow-sm"
                                >
                                    <span x-text="selected || 'Select'"></span>
                                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <!-- Dropdown List -->
                                <div 
                                    x-show="open" 
                                    @click.outside="open = false"
                                    x-transition
                                    class="absolute z-10 mt-2 w-full bg-white divide-y divide-gray-100 rounded-md shadow-lg"
                                >
                                    <ul class="py-1 text-sm text-gray-700">
                                        <template x-for="option in options" :key="option">
                                            <li>
                                                <a 
                                                    href="#" 
                                                    @click.prevent="select(option)" 
                                                    x-text="option"
                                                    class="block px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                                    :class="{ 'bg-gray-100 font-semibold': selected === option }"
                                                ></a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <input type="hidden" name="semester" x-model="selected" required>
                            </div>
                            
                            <!-- Year inputs -->
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
                                    placeholder="e.g., 2024"
                                    class="block w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm"
                                >
                            </div>
                            
                            <div>
                                <label for="year-end" class="block text-sm font-medium text-gray-700 mb-1">
                                    Academic Year End
                                </label>
                                <input 
                                    type="number" 
                                    id="year-end"
                                    :value="yearStart ? parseInt(yearStart) + 1 : ''" 
                                    disabled
                                    class="block w-full rounded-md border-0 py-2 px-3 text-gray-500 bg-gray-100 shadow-sm ring-1 ring-inset ring-gray-200 sm:text-sm"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action buttons - Reordered with Delete first -->
                <div class="bg-gray-50 px-4 py-3 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end sm:gap-3">
                    <button 
                        @click="open = false"
                        type="button"
                        class="w-full inline-flex justify-center rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-colors duration-200 sm:w-auto"
                    >
                        Cancel
                    </button>
                    
                    <!-- Delete button moved up -->
                    <button 
                        @click.prevent="deleteSemester()"
                        type="button"
                        class="delete-btn w-full inline-flex justify-center rounded-md bg-red-100 px-3 py-2 text-sm font-semibold text-red-700 shadow-sm hover:bg-red-200 transition-colors focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                    >
                        Delete Semester
                    </button>
                    
                    <!-- Save changes button -->
                    <button 
                        type="submit"
                        class="w-full inline-flex justify-center rounded-md bg-navgreen px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition-colors focus:ring-2 focus:ring-green-600 focus:ring-offset-2 sm:w-auto"
                        :disabled="!selected || !yearStart"
                        :class="{ 'opacity-50 cursor-not-allowed': !selected || !yearStart }"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>