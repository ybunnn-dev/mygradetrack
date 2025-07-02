// Sample data for demonstration
let semesters = [
  { id: 1, semester: '1st', yearStart: 2023, yearEnd: 2024, gpa: 3.75 },
  { id: 2, semester: '2nd', yearStart: 2023, yearEnd: 2024, gpa: 3.92 }
];

let courses = {
  1: [
    { id: 1, courseCode: 'CS101', courseName: 'Introduction to Programming', units: 3, grade: 'A', remarks: 'Passed' },
    { id: 2, courseCode: 'MATH101', courseName: 'Calculus I', units: 4, grade: 'B+', remarks: 'Passed' }
  ],
  2: [
    { id: 3, courseCode: 'CS102', courseName: 'Data Structures', units: 3, grade: 'A-', remarks: 'Passed' },
    { id: 4, courseCode: 'MATH102', courseName: 'Calculus II', units: 4, grade: 'A', remarks: 'Passed' }
  ]
};

let currentSemesterId = 1;

// Function to load semester grades
function loadSemesterGrades(semesterId) {
  currentSemesterId = semesterId;
  
  // Update active semester styling
  document.querySelectorAll('.semester-item').forEach(item => {
    item.classList.remove('border-blue-500', 'bg-blue-50');
  });
  document.querySelector(`.semester-item[data-semester="${semesterId}"]`).classList.add('border-blue-500', 'bg-blue-50');
  
  // Find semester data
  const semester = semesters.find(s => s.id === semesterId);
  if (semester) {
    document.getElementById('current-semester').textContent = `${semester.semester} Semester ${semester.yearStart}-${semester.yearEnd}`;
  }
  
  // Update grades table
  updateGradesTable(courses[semesterId] || []);
}

// Function to handle adding a new semester
function addSemester() {
  openSemesterModal();
}

// Function to handle adding a new course
function addCourse() {
  openCourseModal();
}

// Function to edit a course
function editCourse(courseId) {
  const semesterCourses = courses[currentSemesterId] || [];
  const course = semesterCourses.find(c => c.id === courseId);
  
  if (course) {
    document.getElementById('courseCode').value = course.courseCode;
    document.getElementById('courseName').value = course.courseName;
    document.getElementById('units').value = course.units;
    document.getElementById('grade').value = course.grade;
    window.editingCourseId = courseId;
    openCourseModal();
  }
}

// Function to delete a course
function deleteCourse(courseId) {
  if (confirm('Are you sure you want to delete this course?')) {
    const semesterCourses = courses[currentSemesterId] || [];
    const index = semesterCourses.findIndex(c => c.id === courseId);
    
    if (index > -1) {
      semesterCourses.splice(index, 1);
      updateGradesTable(semesterCourses);
      updateSemesterGPA();
    }
  }
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

// Helper function to get remark color based on grade
function getRemarkColor(grade) {
  const failingGrades = ['F', 'INC', 'W'];
  return failingGrades.includes(grade) ? 'text-red-600' : 'text-green-600';
}

// Helper function to get remark text based on grade
function getRemarkText(grade) {
  const failingGrades = ['F', 'INC', 'W'];
  return failingGrades.includes(grade) ? 'Failed' : 'Passed';
}

// Function to calculate GPA
function calculateGPA(coursesData) {
  if (coursesData.length === 0) return 0;
  
  const gradeValues = {
    'A': 4.0, 'A-': 3.7, 'B+': 3.3, 'B': 3.0, 'B-': 2.7,
    'C+': 2.3, 'C': 2.0, 'C-': 1.7, 'D+': 1.3, 'D': 1.0, 'F': 0.0
  };
  
  let totalGradePoints = 0;
  let totalUnits = 0;
  
  coursesData.forEach(course => {
    if (gradeValues.hasOwnProperty(course.grade)) {
      totalGradePoints += gradeValues[course.grade] * course.units;
      totalUnits += course.units;
    }
  });
  
  return totalUnits > 0 ? (totalGradePoints / totalUnits).toFixed(2) : 0;
}

// Function to update semester GPA
function updateSemesterGPA() {
  const semesterCourses = courses[currentSemesterId] || [];
  const gpa = calculateGPA(semesterCourses);
  
  const semester = semesters.find(s => s.id === currentSemesterId);
  if (semester) {
    semester.gpa = parseFloat(gpa);
  }
  
  const semesterElement = document.querySelector(`.semester-item[data-semester="${currentSemesterId}"] .bg-green-100`);
  if (semesterElement) {
    semesterElement.textContent = `GPA: ${gpa}`;
  }
}

// Function to refresh semester list (called after adding semester)
function refreshSemesterList() {
  const semestersList = document.getElementById('semesters-list');
  semestersList.innerHTML = '';
  
  semesters.forEach(semester => {
    const semesterDiv = document.createElement('div');
    semesterDiv.className = 'p-2 sm:p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition semester-item';
    semesterDiv.setAttribute('data-semester', semester.id);
    semesterDiv.onclick = () => loadSemesterGrades(semester.id);
    
    semesterDiv.innerHTML = `
      <div class="flex justify-between items-center">
        <div>
          <div class="text-sm sm:text-base font-medium">${semester.semester} Semester</div>
          <div class="text-xs text-gray-500">${semester.yearStart}-${semester.yearEnd}</div>
        </div>
        <span class="text-xs sm:text-sm bg-green-100 text-green-800 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded">GPA: ${semester.gpa}</span>
      </div>
    `;
    
    semestersList.appendChild(semesterDiv);
  });
}

// Function to refresh grades table (called after adding course)
function refreshGradesTable() {
  updateGradesTable(courses[currentSemesterId] || []);
  updateSemesterGPA();
}

// Override the modal success callbacks
function onSemesterAdded(semesterData) {
  const newSemester = {
    id: Date.now(),
    semester: semesterData.semester,
    yearStart: parseInt(semesterData.yearStart),
    yearEnd: parseInt(semesterData.yearEnd),
    gpa: 0
  };
  
  semesters.push(newSemester);
  courses[newSemester.id] = [];
  refreshSemesterList();
  loadSemesterGrades(newSemester.id);
}

function onCourseAdded(courseData) {
  const newCourse = {
    id: Date.now(),
    courseCode: courseData.courseCode,
    courseName: courseData.courseName,
    units: parseInt(courseData.units),
    grade: courseData.grade,
    remarks: getRemarkText(courseData.grade)
  };
  
  if (!courses[currentSemesterId]) {
    courses[currentSemesterId] = [];
  }
  
  if (window.editingCourseId) {
    const index = courses[currentSemesterId].findIndex(c => c.id === window.editingCourseId);
    if (index > -1) {
      newCourse.id = window.editingCourseId;
      courses[currentSemesterId][index] = newCourse;
    }
    delete window.editingCourseId;
  } else {
    courses[currentSemesterId].push(newCourse);
  }
  
  refreshGradesTable();
}

// Initialize with first semester selected
document.addEventListener('DOMContentLoaded', function() {
  loadSemesterGrades(1);
  vakla();
});

function vakla(){
    console.log("vakla");
}

/***********************For Add Course****************************/
/*************************************************************/
    document.addEventListener('alpine:init', () => {
        Alpine.data('addCourseModal', () => ({
            open: false,
            courseCode: '',
            courseName: '',
            units: '',
            grade: '',

            submit() {
                // Validate grade
                const gradeValue = parseFloat(this.grade);
                if (isNaN(gradeValue)) {
                    alert('Please enter a valid grade between 1.0 and 4.0');
                    return;
                }

                const payload = {
                    courseCode: this.courseCode.toUpperCase(),
                    courseName: this.courseName,
                    units: this.units,
                    grade: this.grade,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route("courses.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': payload._token
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => {
                    if (!res.ok) throw new Error('Failed to add course');
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        this.open = false;
                        this.resetForm();
                        window.dispatchEvent(new CustomEvent('course-added', { detail: data }));
                    } else {
                        alert(data.message || 'Error adding course.');
                    }
                })
                .catch(err => {
                    alert(err.message);
                });
            },

            resetForm() {
                this.courseCode = '';
                this.courseName = '';
                this.units = '';
                this.grade = '';
            }
        }));
    });