export default () => ({
    // State
    open: false,
    semester: '',
    yearStart: new Date().getFullYear().toString(),
    isLoading: false,
    dropdownOpen: false,
    semesterOptions: ['1st Semester', '2nd Semester', 'Midyear'],

    // Computed property
    get yearEnd() {
        return this.yearStart ? (parseInt(this.yearStart) + 1).toString() : '';
    },

    // Methods
    selectSemester(option, event) {
        event.preventDefault(); // Stop the default action
        event.stopPropagation(); // Prevent event bubbling
        this.semester = option;
        this.dropdownOpen = false;
    },

   async submit() {
        event.preventDefault();
        
        if (!this.semester || !this.yearStart) {
            alert('Please fill in all required fields.');
            return;
        }

        this.isLoading = true;
        
        try {
            const response = await fetch('/semesters/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    semester: this.semester,
                    yearStart: this.yearStart,
                    yearEnd: this.yearEnd
                })
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to create semester');
            }

            this.open = false;
            this.semester = '';
            this.yearStart = new Date().getFullYear().toString();
            
            window.dispatchEvent(new CustomEvent('semester-added', {
                detail: data
            }));
            
            // Optional: Show success message
            alert('Semester created successfully!');
            window.location.reload();
            
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        } finally {
            this.isLoading = false;
        }
    }
});