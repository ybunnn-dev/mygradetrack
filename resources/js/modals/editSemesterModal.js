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

        const showRoute = window.routes.showSemester.replace(':id', this.semesterId);

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
        if (!this.semester || !this.yearStart) {
            alert('Please fill in all required fields.');
            return;
        }

        const updateRoute = window.routes.updateSemester.replace(':id', this.semesterId);
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
        if (!confirm('Are you sure you want to delete this semester? All associated courses will also be deleted.')) {
            return;
        }

        const deleteRoute = window.routes.deleteSemester.replace(':id', this.semesterId);
        const deleteBtn = this.$el.querySelector('button[text-red-700]');
        const originalText = deleteBtn.textContent;
        
        deleteBtn.textContent = 'Deleting...';
        deleteBtn.disabled = true;

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
            } else {
                alert(data.message || 'Failed to delete semester.');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            deleteBtn.textContent = originalText;
            deleteBtn.disabled = false;
        });
    }
});