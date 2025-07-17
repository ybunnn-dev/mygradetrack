// resources/js/app.js

import './bootstrap';

import Alpine from 'alpinejs';

// Import your custom Alpine data files
import addSemesterModal from './modals/addSemesterModal.js';
import addCourseModal from './modals/addCourseModal.js';
import editCourseModal from './modals/editCourseModal.js';
import editSemesterModal from './modals/editSemesterModal.js';
import sideMenu from './components/side-menu.js'; // <-- NEW: Import sideMenu data

// IMPORTANT: If Livewire is managing Alpine, these lines should remain commented out/removed
// window.Alpine = Alpine;
// Alpine.start();

document.addEventListener('alpine:init', () => {
    // Register your Alpine data components
    Alpine.data('addSemesterModal', addSemesterModal);
    Alpine.data('addCourseModal', addCourseModal);
    Alpine.data('editCourseModal', editCourseModal);
    Alpine.data('editSemesterModal', editSemesterModal);
    Alpine.data('sideMenu', sideMenu); // <-- NEW: Register sideMenu data
});

// IMPORTANT: If Livewire is managing Alpine, this line should remain commented out/removed
//Alpine.start();