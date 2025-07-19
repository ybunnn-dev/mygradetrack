let allCourses = {};

window.currentSemesterId = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize by loading the first semester if available
    const firstSemester = document.querySelector('.semester-item');
    if (firstSemester) {
        currentSemesterId = firstSemester.dataset.semester;
        loadSemesterGrades(currentSemesterId);
    }

    // Add event listeners to all semester items
    document.querySelectorAll('.semester-item').forEach(item => {
        item.addEventListener('click', function() {
            currentSemesterId = this.dataset.semester;
            loadSemesterGrades(currentSemesterId);
        });
    });

});

function loadSemesterGrades(semesterId) {
    fetch(`/semesters/${semesterId}/courses`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(allCourses);
            updateSemesterDisplay(data.semester);
            updateCoursesTable(data.courses);
        })
        .catch(error => {
            console.error('Error loading semester grades:', error);
            showError('Failed to load semester data');
        });
}

function updateSemesterDisplay(semester) {
    const semesterTitle = document.getElementById('current-semester');
    currentSemesterId = `${semester.id}`;
    if (semesterTitle) {
        semesterTitle.textContent = 
            `${semester.semester}${semester.semester !== 'Midyear' ? 'ester' : ''} ${semester.start_year}-${semester.end_year}`
    }
}

function updateCoursesTable(courses) {
    const tbody = document.getElementById('grades-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (courses.length > 0) {
        courses.forEach(course => {
            const grade = parseFloat(course.grade).toFixed(2);
            const passed = grade <= 3.0;
            const excellent = grade <= 1.75;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="py-2 truncate text-left">${course.course_code || 'N/A'}</td>
                <td class="py-2 break-words text-left">${course.course_name}</td>
                <td class="py-2 text-center">${course.units}</td>
                <td class="py-2 text-center font-semibold ${excellent ? 'text-green-600' : (passed ? 'text-yellow-600' : 'text-red-600')}">
                    ${grade}
                </td>
                <td class="py-2 text-left ${passed ? 'text-green-600' : 'text-red-600'}">
                    ${passed ? 'Passed' : 'Failed'}
                </td>
                <td class="py-2 text-left">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="editCourse(${course.id})" class="text-blue-600 hover:text-blue-900 text-[0.6875rem]">Edit</button>
                        <button onclick="deleteCourse(${course.id})" class="text-red-600 hover:text-red-900 text-[0.6875rem]">Delete</button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        row.innerHTML = '<td colspan="6" class="py-4 text-center text-gray-500">No courses found for this semester</td>';
        tbody.appendChild(row);
    }
}

function showError(message) {
    const tbody = document.getElementById('grades-table-body');
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-4 text-center text-red-600">
                    ${message}
                </td>
            </tr>
        `;
    }
}

// Make these functions available globally for inline event handlers
window.loadSemesterGrades = loadSemesterGrades;

function addSemester() {
  openSemesterModal();
}

// Click handler for edit buttons
document.addEventListener('click', function(event) {
  if (event.target.matches('[data-edit-course]')) {
    const courseId = event.target.dataset.courseId;
    editCourse(courseId);
  }
});

// Edit course function
async function editCourse(courseId) {
  try {
    // Load fresh data if needed (or use cached)
    if (!Object.keys(allCourses).length) {
      await loadAllCourses();
    }

    const semesterCourses = allCourses[currentSemesterId] || [];
    const course = semesterCourses.find(c => c.id == courseId);

    if (course) {
      window.dispatchEvent(new CustomEvent('open-edit-course', {
        detail: {
          id: course.id,
          courseCode: course.courseCode || '',
          courseName: course.courseName || course.course_name || '',
          units: course.units || '',
          grade: course.grade || ''
        }
      }))
    } else {
      console.error('Course not found');
      alert('Course data could not be loaded');
    }
  } catch (error) {
    console.error('Edit failed:', error);
    alert('Error loading course details');
  }
}

// Data loader
async function loadAllCourses() {
  try {
    const response = await fetch('/edit-course', {
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    });
    
    if (!response.ok) throw new Error('Failed to load');
    
    const data = await response.json();
    allCourses = data.courses;
    currentSemesterId = data.semesters[0]?.id || null;
  } catch (error) {
    console.error('Load failed:', error);
    throw error;
  }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
  loadAllCourses().catch(e => console.error('Initial load failed:', e));
});

// Function to delete a course
window.deleteCourse = function(id) {
  if (!confirm('Are you sure you want to delete this course?')) return;

  fetch(`/courses/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
  .then(response => {
    if (!response.ok) throw new Error('Failed to delete course from server.');
    return response.json();
  })
  .then(data => {
    if (data.success) {
      // Remove from local list and update table
      const semesterCourses = allCourses[currentSemesterId] || [];
      const index = semesterCourses.findIndex(c => c.id === id);
      if (index > -1) {
        window.location.reload();
      }
    } else {
      alert(data.message || 'Failed to delete course.');
    }
  })
  .catch(error => {
    console.error('Delete error:', error);
    alert('An error occurred while deleting the course.');
  });
}

// Function to update grades table with new data
function updateGradesTable(coursesData) {
  const tbody = document.getElementById('grades-table-body');
  tbody.innerHTML = '';
  
  if (coursesData.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
          No courses added yet. Click "Add Course" to get started.
        </td>
      </tr>
    `;
    return;
  }
  
  coursesData.forEach(course => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td class="py-2 truncate text-left text-xs font-medium text-text_light">${course.courseCode}</td>
      <td class="py-2 break-words text-left text-xs font-medium text-text_light">${course.courseName}</td>
      <td class="py-2 text-center text-xs font-medium text-text_light">${course.units}</td>
      <td class="py-2 text-center text-xs font-medium text-text_light">${course.grade}</td>
      <td class="py-2 text-left text-xs font-medium ${getRemarkColor(course.grade)}">${getRemarkText(course.grade)}</td>
      <td class="py-2 text-left">
        <div class="flex flex-col sm:flex-row gap-3">
          <button onclick="editCourse(${course.id})" class="text-blue-600 hover:text-blue-900 text-[0.6875rem] font-medium">Edit</button>
          <button onclick="deleteCourse(${course.id})" class="text-red-600 hover:text-red-900 text-[0.6875rem] font-medium">Delete</button>
        </div>
      </td>
    `;
    tbody.appendChild(row);
  });
}
