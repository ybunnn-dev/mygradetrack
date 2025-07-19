
export default () => ({
    editModalOpen: false,  // Unique name for edit modal
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

    submitEdit() {
        const gradeValue = parseFloat(this.editGrade);
        if (isNaN(gradeValue) || gradeValue < 1.0 || gradeValue > 5.0) {
            alert('Please enter a valid grade between 1.0 and 5.0');
            return;
        }

        const payload = {
            courseCode: this.editCourseCode.toUpperCase(),
            courseName: this.editCourseName,
            units: this.editUnits,
            grade: this.editGrade,
            _token: document.querySelector('meta[name="csrf-token"]').content
        };

        fetch(`/courses/${this.editCourseId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': payload._token,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) throw new Error('Failed to update course');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.editModalOpen = false;
                this.resetEditForm();
                window.dispatchEvent(new CustomEvent('course-updated', {
                    detail: {
                        courseId: this.editCourseId,
                        updatedCourse: data.course
                    }
                }));
            } else {
                alert(data.message || 'Error updating course.');
            }
        })
        .catch(err => {
            alert(err.message);
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