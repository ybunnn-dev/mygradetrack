export default () => ({
    editModalOpen: false, // Unique name for edit modal
    editCourseId: null,
    editCourseCode: '',
    editCourseName: '',
    editUnits: '',
    editGrade: '',

    openEditWith(course) {
        this.editCourseId = course.id;
        this.editCourseCode = course.courseCode || '';
        this.editCourseName = course.courseName || course.course_name || '';
        this.editUnits = course.units || '';
        this.editGrade = course.grade || '';
        this.editModalOpen = true;
    },

    // This method will be called first to trigger the confirmation
    promptEditConfirmation() {
        const gradeValue = parseFloat(this.editGrade);
        if (isNaN(gradeValue) || gradeValue < 1.0 || gradeValue > 5.0) {
            alert('Please enter a valid grade between 1.0 and 5.0');
            return;
        }

        // Dispatch the generic 'show-confirmation' event
        window.dispatchEvent(new CustomEvent('show-confirmation', {
            detail: {
                message: `Are you sure you want to save changes for "${this.editCourseName}" (${this.editCourseCode})?`,
                onConfirm: () => this.performEditSubmit() // Pass the actual submission logic as the callback
            }
        }));
    },

    // This method contains the actual fetch logic and will be called ONLY after confirmation
    performEditSubmit() {
        const payload = {
            courseCode: this.editCourseCode.trim().toUpperCase(), // Trim and uppercase for consistency
            courseName: this.editCourseName.trim(), // Trim for consistency
            units: parseInt(this.editUnits),
            grade: this.editGrade,
            _token: document.querySelector('meta[name="csrf-token"]').content
        };

        fetch(`/courses/${this.editCourseId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': payload._token,
                // 'X-HTTP-Method-Override': 'PUT' // Generally not needed if backend explicitly handles PUT
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            if (!res.ok) {
                const err = await res.json();
                throw new Error(err.message || 'Failed to update course');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.editModalOpen = false; // Close the edit course modal
                this.resetEditForm();
                window.dispatchEvent(new CustomEvent('course-updated', {
                    detail: {
                        courseId: this.editCourseId,
                        updatedCourse: data.course
                    }
                }));
                window.location.reload(); // Reload to reflect changes, or update UI dynamically if preferred
            } else {
                alert(data.message || 'Error updating course.');
            }
        })
        .catch(err => {
            alert('An error occurred: ' + err.message);
            console.error('Error updating course:', err);
        });
    },

    resetEditForm() {
        this.editCourseId = null;
        this.editCourseCode = '';
        this.editCourseName = '';
        this.editUnits = '';
        this.editGrade = '';
    }
});