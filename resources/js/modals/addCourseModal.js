export default () => ({
    open: false,
    courseCode: '',
    courseName: '',
    units: '',
    grade: '',

    submit() {
        const gradeValue = parseFloat(this.grade);
        if (isNaN(gradeValue) || gradeValue < 1.0 || gradeValue > 4.0) {
            alert('Please enter a valid grade between 1.0 and 4.0');
            return;
        }

        if (!window.currentSemesterId) {
            alert('Semester is not selected. Please choose a semester first.');
            return;
        }

        const payload = {
            semester_id: window.currentSemesterId, // must exist
            courseCode: this.courseCode.trim().toUpperCase(),
            courseName: this.courseName.trim(),
            units: parseInt(this.units),
            grade: this.grade
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/store-course', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            if (!res.ok) {
                const err = await res.json();
                throw new Error(err.message || 'Failed to add course.');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.open = false;
                this.resetForm();
                window.dispatchEvent(new CustomEvent('course-added', { detail: data }));
            } else {
                alert(data.message || 'Unexpected error while adding course.');
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
