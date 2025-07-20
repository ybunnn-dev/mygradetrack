// edit-semester-modal.js
export default () => ({
    open: false,
    semesterId: null,
    semester: '',
    yearStart: new Date().getFullYear().toString(),

    get yearEnd() {
        return this.yearStart ? parseInt(this.yearStart) + 1 : '';
    },

    loadSemesterData() {
        this.semesterId = window.currentSemesterId;

        if (!this.semesterId) {
            console.error('No semester ID found for editing');
            return;
        }

        const showRoute = `/semesters/${this.semesterId}`;

        fetch(showRoute, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Failed to fetch semester data');
            }
            return res.json();
        })
        .then(data => {
            this.semester = data.semester;
            this.yearStart = data.start_year.toString();
        })
        .catch(error => {
            console.error('Error loading semester:', error);
            alert('Failed to load semester data');
        });
    },

    // --- New method to prompt confirmation for updating semester ---
    promptUpdateConfirmation() {
        console.log('Prompting update confirmation with:', {
            semester: this.semester,
            yearStart: this.yearStart,
            yearEnd: this.yearEnd,
            semesterId: this.semesterId
        });

        if (!this.semester || !this.yearStart) {
            alert('Please fill in all required fields.');
            return;
        }

        const displaySemester = this.semester === '1st Semester' ? '1st Sem'
                                : this.semester === '2nd Semester' ? '2nd Sem'
                                : this.semester;
        const displayYear = `${this.yearStart}-${parseInt(this.yearStart) + 1}`;

        window.dispatchEvent(new CustomEvent('show-confirmation', {
            detail: {
                message: `Are you sure you want to update this semester to ${displaySemester} ${displayYear}?`,
                onConfirm: () => this.performUpdateSubmit() // Callback for actual update
            }
        }));
    },

    // --- Renamed and refactored 'submit' to 'performUpdateSubmit' ---
    performUpdateSubmit() {
        const updateRoute = `/semesters/${this.semesterId}`;
        console.log('Update route:', updateRoute);

        // Instead of directly manipulating the button here, you might consider an isLoading state
        // or a global loading indicator if you have one. For simplicity, keeping direct manipulation.
        const submitBtn = this.$el.querySelector('button[type="submit"]');
        const originalText = submitBtn ? submitBtn.textContent : 'Update'; // Handle case if button not found
        if (submitBtn) {
            submitBtn.textContent = 'Saving...';
            submitBtn.disabled = true;
        }

        fetch(updateRoute, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                semester: this.semester,
                yearStart: this.yearStart,
                yearEnd: this.yearEnd
            })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => { throw new Error(err.message || 'Server error'); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.open = false; // Close the edit semester modal
                window.dispatchEvent(new CustomEvent('semester-updated', {
                    detail: {
                        id: this.semesterId,
                        semester: data.semester,
                        yearStart: data.yearStart,
                        yearEnd: data.yearEnd
                    }
                }));
                alert('Semester updated successfully!'); // Provide immediate feedback
                window.location.reload(); // Reload or dynamically update UI
            } else {
                alert(data.message || 'Failed to update semester.');
            }
        })
        .catch(error => {
            console.error('Update error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    },

    // --- New method to prompt confirmation for deleting semester ---
    promptDeleteConfirmation() {
        console.log('Prompting delete confirmation with semesterId:', this.semesterId);

        window.dispatchEvent(new CustomEvent('show-confirmation', {
            detail: {
                message: `Are you sure you want to delete this semester? All associated courses will also be deleted.`,
                onConfirm: () => this.performDeleteSemester() // Callback for actual deletion
            }
        }));
    },

    // --- Renamed and refactored 'deleteSemester' to 'performDeleteSemester' ---
    performDeleteSemester() {
        console.log('Performing delete with semesterId:', this.semesterId);

        const deleteRoute = `/semesters/${this.semesterId}`;
        console.log('Delete route:', deleteRoute);

        const deleteBtn = this.$el.querySelector('.delete-btn'); // Assuming you still use a class for this button
        let originalText;
        if (deleteBtn) {
            originalText = deleteBtn.textContent;
            deleteBtn.textContent = 'Deleting...';
            deleteBtn.disabled = true;
        }

        fetch(deleteRoute, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => { throw new Error(err.message || 'Server error'); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.open = false; // Close the edit semester modal
                window.dispatchEvent(new CustomEvent('semester-deleted', {
                    detail: {
                        id: this.semesterId
                    }
                }));
                alert('Semester deleted successfully!'); // Provide immediate feedback
                window.location.reload(); // Reload or dynamically update UI
            } else {
                alert(data.message || 'Failed to delete semester.');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            if (deleteBtn) {
                deleteBtn.textContent = originalText;
                deleteBtn.disabled = false;
            }
        });
    }
});