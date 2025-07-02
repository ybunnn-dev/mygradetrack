// Option 1: Standard approach - define the data object directly
export default () => ({
    open: false,
    semester: '',
    yearStart: new Date().getFullYear().toString(),

    get yearEnd() {
        return this.yearStart ? parseInt(this.yearStart) + 1 : '';
    },

    submit() {
        if (!this.semester || !this.yearStart) {
            alert('Please fill in all required fields.');
            return;
        }

        // Using window.routes for dynamic routing - ensure it's accessible globally
        const storeRoute = window.routes.storeSemester;

        // Best practice: Scope querySelector to the current component for reliability
        // Find the submit button within the current component's scope
        const submitBtn = this.$el.querySelector('button[type="submit"]'); // Use this.$el to query within the component
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Adding...';
        submitBtn.disabled = true;

        fetch(storeRoute, {
            method: 'POST',
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
                this.semester = '';
                this.yearStart = new Date().getFullYear().toString();

                window.dispatchEvent(new CustomEvent('semester-added', {
                    detail: {
                        semester: data.semester || 'N/A',
                        yearStart: data.yearStart || 'N/A',
                        yearEnd: data.yearEnd || 'N/A'
                    }
                }));
            } else {
                alert(data.message || 'Failed to add semester.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    }
});