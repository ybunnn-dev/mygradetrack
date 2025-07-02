// resources/js/modals/addCourseModal.js

export default () => ({
    open: false,
    courseCode: '',
    courseName: '',
    units: '',
    grade: '',

    submit() {
        const gradeValue = parseFloat(this.grade);
        if (isNaN(gradeValue) || gradeValue < 1.0 || gradeValue > 4.0) { // Added min/max validation for grade
            alert('Please enter a valid grade between 1.0 and 4.0');
            return;
        }

        // You might want to add validation for other fields as well

        const payload = {
            courseCode: this.courseCode.toUpperCase(),
            courseName: this.courseName,
            units: this.units,
            grade: this.grade,
            // _token is no longer needed here as it's in the header
        };

        // Get CSRF token from the meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Use the globally defined route
        fetch(window.routes.storeCourse, { // <--- Changed from '{{ route("courses.store") }}'
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // <--- Changed from payload._token
            },
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) {
                // If the server sends back JSON with errors, parse it
                return res.json().then(err => {
                    throw new Error(err.message || 'Failed to add course');
                });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.open = false;
                this.resetForm();
                // Consider adding a success message/notification here
                window.dispatchEvent(new CustomEvent('course-added', { detail: data }));
            } else {
                alert(data.message || 'Error adding course.');
            }
        })
        .catch(err => {
            console.error('Error adding course:', err);
            alert('An error occurred: ' + err.message);
        });
    },

    resetForm() {
        this.courseCode = '';
        this.courseName = '';
        this.units = '';
        this.grade = '';
    }
});