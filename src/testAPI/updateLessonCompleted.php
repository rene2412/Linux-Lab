<?php
// Allow cross-origin requests if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Get the JSON data sent from JavaScript
$requestData = json_decode(file_get_contents('php://input'), true);

// Validate the data
if (!isset($requestData['section']) || !isset($requestData['lesson'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Load the current lessons data
$lessonsDataPath = './lessons.json';
$lessonsData = json_decode(file_get_contents($lessonsDataPath), true);

// Get the section and lesson IDs from the request
$sectionId = $requestData['section'];
$lessonId = $requestData['lesson'];
$completedStatus = isset($requestData['completed']) ? $requestData['completed'] : true;

// Flag to track if we found and updated the lesson
$lessonFound = false;

// Loop through the lessons data to find the matching section and lesson
foreach ($lessonsData as $section => &$lessons) {
    if ($section === $sectionId) {
        // Check if this is a nested array structure with lesson objects
        foreach ($lessons as &$lesson) {
            // Check if this lesson has an id field and it matches the requested lesson id
            if (isset($lesson['id']) && $lesson['id'] == $lessonId && isset($lesson['parent']) && $lesson['parent'] === $sectionId) {
                // Update the completed status
                $lesson['completed'] = $completedStatus;
                $lessonFound = true;
                break;
            }
        }
        
        // Check if we need to update the section__completed status
        if ($lessonFound && isset($lessons[0]['section__completed'])) {
            // Check if all lessons in this section are completed
            $allCompleted = true;
            for ($i = 1; $i < count($lessons); $i++) {
                if (isset($lessons[$i]['completed']) && $lessons[$i]['completed'] === false) {
                    $allCompleted = false;
                    break;
                }
            }
            $lessons[0]['section__completed'] = $allCompleted;
        }
    }
}

// Write the updated data back to the file if a lesson was found and updated
if ($lessonFound) {
    if (file_put_contents($lessonsDataPath, json_encode($lessonsData, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Lesson completion status updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to write lesson data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Lesson not found']);
}
?>