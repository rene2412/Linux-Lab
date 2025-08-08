// Initialize Matrix Rain Effect
function createMatrixRain() {
    const matrixBg = document.getElementById('matrixBg');
    const chars = '01abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';
    
    for (let i = 0; i < 50; i++) {
        const char = document.createElement('div');
        char.className = 'matrix-char';
        char.textContent = chars[Math.floor(Math.random() * chars.length)];
        char.style.left = Math.random() * 100 + '%';
        char.style.animationDuration = (Math.random() * 3 + 2) + 's';
        char.style.animationDelay = Math.random() * 2 + 's';
        matrixBg.appendChild(char);
    }
}

// Initialize Ace Editor
const editor = ace.edit("editor");
editor.setTheme("ace/theme/twilight");
editor.session.setMode("ace/mode/sh");
editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true,
    fontSize: 14,
    showPrintMargin: false,
    wrap: true,
    tabSize: 2,
    useSoftTabs: true,
    cursorStyle: "wide"
});

// Update status bar
function updateStatus() {
    const cursor = editor.getCursorPosition();
    document.getElementById('lineNumber').textContent = cursor.row + 1;
    document.getElementById('columnNumber').textContent = cursor.column + 1;
}

editor.on('changeSelection', updateStatus);
editor.on('changeCursor', updateStatus);

// DO NOT TOUCH THIS FUNCTION
// Function will run code and send it the backend to Spring Boot for docker containment
async function runCode() {
    const code = editor.getValue().trim();
    const runButton = document.querySelector('.btn-run');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const output = document.getElementById('output');
    const outputContent = document.getElementById('outputContent');
    
    if (!code) {
        alert('Please write a bash script first!');
        return;
    }

    // Show loading state
    runButton.classList.add('running');
    runButton.innerHTML = '<span>Running...</span>';
    loadingSpinner.style.display = 'inline-block';
    
    // Show output container
    output.style.display = 'block';
    outputContent.textContent = 'Executing script...\n';

    try {
        console.log('Sending script to backend:', code); // Debug log
        
        // Send code to Spring Boot backend
        const response = await fetch('/api/script', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ script: code })
        });

        console.log('Response status:', response.status); // Debug log

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
        }

        const result = await response.json();
        console.log('Backend response:', result); // Debug log
        
        // Clear previous output
        outputContent.textContent = '';
        
        // Display result
        if (result.output && result.output.length > 0) {
            outputContent.textContent += result.output;
        } else {
           // outputContent.textContent += ' Output:\n(No output produced)';
        }
        
        if (result.error && result.error.length > 0) {
            outputContent.textContent += '\n\n' + result.error;
        }
        
        // Show execution status
        /*
        if (result.success !== undefined) {
            if (result.success) {
                outputContent.textContent += '\n\n\n\nScript executed successfully!';
            } else {
                outputContent.textContent += `\n\n\n\nScript failed with exit code: ${result.exitCode || 'unknown'}`;
            }
        }
        */
        if (result.executionTime) {
            outputContent.textContent += `\nExecution time: ${result.executionTime}ms`;
        }
        
    } catch (error) {
        console.error('Error executing script:', error);
        outputContent.textContent = '';
        outputContent.textContent += 'Connection Error:\n' + error.message;
        outputContent.textContent += '\n\n Falling back to simulation mode...\n\n';
        
        // Fallback to simulation if backend is not available
        const simulatedOutput = simulateAdvancedBash(code);
        outputContent.textContent += simulatedOutput;
        
    } finally {
        // Reset button and spinner
        runButton.classList.remove('running');
        runButton.innerHTML = '<span>▶</span><span>Run</span>';
        loadingSpinner.style.display = 'none';
        
        // Scroll to bottom
        outputContent.scrollTop = outputContent.scrollHeight;
    }
}

// Save file
function saveFile() {
    const content = editor.getValue();
    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'script.sh';
    a.click();
    URL.revokeObjectURL(url);
}

// Load file
function loadFile() {
    document.getElementById('fileInput').click();
}

function handleFileLoad() {
    const file = document.getElementById('fileInput').files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            editor.setValue(e.target.result);
            editor.clearSelection();
            updateStatus();
        };
        reader.readAsText(file);
    }
}

// Clear editor
function clearEditor() {
    if (confirm('Are you sure you want to clear the editor?')) {
        editor.setValue('#!/bin/bash\n# Write your bash script here\n\n');
        editor.clearSelection();
        document.getElementById('output').style.display = 'none';
        updateStatus();
    }
}

// Keyboard shortcuts
editor.commands.addCommand({
    name: 'save',
    bindKey: {win: 'Ctrl-S', mac: 'Command-S'},
    exec: saveFile
});

editor.commands.addCommand({
    name: 'run',
    bindKey: {win: 'Ctrl-Enter', mac: 'Command-Enter'},
    exec: runCode
});

// Lesson navigation
let lessons = [];
let currentLessonIndex = 0;
let totalLessons = 0;

function GetCurrentLesson() {
    return currentLessonIndex;
}

async function loadLessons() {
    const lessonContent = document.getElementById('lessonContent');
    
    try {
        // Show loading indicator
        lessonContent.innerHTML = `
            <div style="text-align: center; padding: 40px; color: #00ff00;">
                <div class="loading-animation" style="display: inline-block; margin-bottom: 10px;"></div>
                <p>Loading lessons...</p>
            </div>
        `;
        
        // Fetch lessons from JSON file
        const response = await fetch('lessons.json');
        
        if (!response.ok) {
            throw new Error(`Failed to load lessons: ${response.status} ${response.statusText}`);
        }
        
        const data = await response.json();
        lessons = data.lessons;
        totalLessons = lessons.length;
        
        // Update total lessons counter
        document.getElementById('totalLessons').textContent = totalLessons;
        
        // Load the first lesson
        if (lessons.length > 0) {
            currentLessonIndex = 0;
            displayLesson(currentLessonIndex);
        } else {
            throw new Error('No lessons found in the JSON file');
        }
        
    } catch (error) {
        console.error('Error loading lessons:', error);
        
        // Show error message
        lessonContent.innerHTML = `
            <div style="background: rgba(255, 0, 0, 0.1); border: 1px solid #ff0000; color: #ff4444; padding: 15px; border-radius: 5px; margin: 10px 0;">
                <h3>❌ Error Loading Lessons</h3>
                <p><strong>Error:</strong> ${error.message}</p>
                <p><strong>Make sure you have a 'lessons.json' file in the same directory.</strong></p>
            </div>
        `;
        
        // Reset counters
        document.getElementById('totalLessons').textContent = '--';
        document.getElementById('currentLesson').textContent = '--';
    }
}

function displayLesson(index) {
    const lessonContent = document.getElementById('lessonContent');
    
    if (index < 0 || index >= lessons.length) {
        console.error('Invalid lesson index:', index);
        return;
    }
    const lesson = lessons[index];
    
    // Build lesson content HTML
    let lessonHTML = `
        <div class="lesson-section">
            <h3>${lesson.title || `Lesson ${index + 1}`}</h3>
           ${lesson.difficulty ? `<p><strong>Difficulty:</strong> <span style="color: #00ff00;">${lesson.difficulty}</span></p>` : '' }
        </div>
    `;
    
    if (lesson.content) {
        lessonHTML += `
            <div class="lesson-section">
                <div>${lesson.content}</div>
            </div>
        `;
    }
    
    if (lesson.tips && lesson.tips.length > 0) {
        lessonHTML += `
            <div class="lesson-section">
                <h3>Tips</h3>
                <ul>
                    ${lesson.tips.map(tip => `<li>${tip}</li>`).join('')}
                </ul>
            </div>
        `;
    }
   

    // Set the lesson content
    lessonContent.innerHTML = lessonHTML;
    
    // Update lesson counter and navigation buttons
    updateLessonCounter();
    
    // Load code example into editor if available
    if (lesson.code_example && lesson.load_in_editor !== false) {
        editor.setValue(lesson.code_example.replace(/\\n/g, '\n'));
        editor.clearSelection();
        updateStatus();
    }
    
    // Scroll to top of lesson content
    lessonContent.scrollTop = 0;
}

function nextLesson() {
    if (currentLessonIndex < totalLessons - 1) {
        currentLessonIndex++;
        displayLesson(currentLessonIndex);
        updateDropdownTitle(lessons[currentLessonIndex]);
    }
}

function previousLesson() {
    if (currentLessonIndex > 0) {
        currentLessonIndex--;
        displayLesson(currentLessonIndex);
        updateDropdownTitle(lessons[currentLessonIndex]); 
    }
}

function updateLessonCounter() {
    document.getElementById('currentLesson').textContent = currentLessonIndex + 1;
    document.getElementById('totalLessons').textContent = totalLessons;
    
    // Update button states
    const prevBtn = document.querySelector('.nav-prev');
    const nextBtn = document.querySelector('.nav-next');
    
    prevBtn.disabled = currentLessonIndex === 0;
    nextBtn.disabled = currentLessonIndex === totalLessons - 1;
}

// Initialize everything
updateStatus();
loadLessons();