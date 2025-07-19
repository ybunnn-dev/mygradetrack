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
        // Get the currently selected semester ID (implementation depends on your app)
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

    submit() {
        console.log('Submit called with:', {
            semester: this.semester,
            yearStart: this.yearStart,
            yearEnd: this.yearEnd,
            semesterId: this.semesterId
        });

        if (!this.semester || !this.yearStart) {
            alert('Please fill in all required fields.');
            return;
        }

        const updateRoute = `/semesters/${this.semesterId}`;
        console.log('Update route:', updateRoute);
        
        const submitBtn = this.$el.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'Saving...';
        submitBtn.disabled = true;

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
                this.open = false;
                window.dispatchEvent(new CustomEvent('semester-updated', {
                    detail: {
                        id: this.semesterId,
                        semester: data.semester,
                        yearStart: data.yearStart,
                        yearEnd: data.yearEnd
                    }
                }));
                window.location.reload();
            } else {
                alert(data.message || 'Failed to update semester.');
            }
        })
        .catch(error => {
            console.error('Update error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    },

    deleteSemester() {
        console.log('Delete called with semesterId:', this.semesterId);
        
        if (!confirm('Are you sure you want to delete this semester? All associated courses will also be deleted.')) {
            return;
        }

        const deleteRoute = `/semesters/${this.semesterId}`;
        console.log('Delete route:', deleteRoute);

        const deleteBtn = this.$el.querySelector('.delete-btn');

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
                throw new Error('Failed to delete semester');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                this.open = false;
                window.dispatchEvent(new CustomEvent('semester-deleted', {
                    detail: {
                        id: this.semesterId
                    }
                }));
                window.location.reload();
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