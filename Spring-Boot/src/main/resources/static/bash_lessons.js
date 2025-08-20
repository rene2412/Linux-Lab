document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown');
    const dropdownBar = document.querySelector('.dropdown-bar');
    const bashLessons = document.querySelector('.bash-lessons');
    const caret = document.querySelector('.caret');

    dropdownBar.addEventListener('click', function() {
        bashLessons.classList.toggle('bash-lessons-open');
        caret.classList.toggle('caret-rotate');
        dropdownBar.classList.toggle('dropdown-bar-clicked');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target)) {
            bashLessons.classList.remove('bash-lessons-open');
            caret.classList.remove('caret-rotate');
            dropdownBar.classList.remove('dropdown-bar-clicked');
        }
    });
});

function parseJson() {
    fetch("lessons.json")
        .then(response => {
            if (!response.ok) throw new Error("Failed To Open 'lessons.json'");
            return response.json();
        })
        .then(data => {
            populateDropdown(data.lessons);
        })
        .catch(error => {
            console.error("Error:", error);
        })
}

function populateDropdown(lessons) {
    const bashLessonsUl = document.querySelector('.bash-lessons');
    
    // Clear existing content
    bashLessonsUl.innerHTML = '';
    
    // Group lessons by section
    const sections = {};
    lessons.forEach(lesson => {
        const sectionName = lesson.section || 'Other';
        if (!sections[sectionName]) {
            sections[sectionName] = [];
        }
        sections[sectionName].push(lesson);
    });
    
    // Set initial lesson title (first lesson by default)
    updateDropdownTitle(lessons[0]);
    
    // Create dropdown items for each section and its lessons
    Object.keys(sections).forEach(sectionName => {
        // Create section header
        const sectionHeader = document.createElement('li');
        sectionHeader.className = 'section-header';
        sectionHeader.textContent = sectionName;
        bashLessonsUl.appendChild(sectionHeader);
        
        // Create lesson items for this section
        sections[sectionName].forEach((lesson, index) => {
            const lessonItem = document.createElement('li');
            lessonItem.className = 'lesson-item';
            lessonItem.textContent = lesson.title;
            lessonItem.setAttribute('data-lesson-index', lessons.indexOf(lesson));
            
            // Add click handler to load lesson
            lessonItem.addEventListener('click', function() {
                const lessonIndex = lessons.indexOf(lesson);
                loadLesson(lessonIndex);
                updateDropdownTitle(lesson);
                // Close dropdown after selection
                document.querySelector('.bash-lessons').classList.remove('bash-lessons-open');
                document.querySelector('.caret').classList.remove('caret-rotate');
                document.querySelector('.dropdown-bar').classList.remove('dropdown-bar-clicked');
            });
            
            bashLessonsUl.appendChild(lessonItem);
        });
    });
}

// Function to update the dropdown title with current lesson
function updateDropdownTitle(lesson) {
    const selectSpan = document.querySelector('.select');
    selectSpan.textContent = lesson.title || 'Select Lesson';
}

// Update your existing displayLesson function to also update the dropdown title
function displayLesson(index) {
    // Your existing displayLesson code here...
    
    // Update dropdown title to show current lesson
    if (lessons && lessons[index]) {
        updateDropdownTitle(lessons[index]);
    }
}

function loadLesson(lessonIndex) {
    currentLessonIndex = lessonIndex;
    displayLesson(lessonIndex);
}

parseJson();