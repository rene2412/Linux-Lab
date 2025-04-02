<?php
session_start();
// Set the content type to JSON
header('Content-Type: application/json');
require_once "../../includes/database.inc.php";
error_reporting(E_ALL & ~E_WARNING); 

$username = $_SESSION["user_username"] ?? null; // Get stored username
$user_id = $_SESSION["user_id"] ?? null;
$logged = false; // Default to false for guests

$lessonId = null;
$lessons_completed = 0;
$current_lesson = "Not Started";
$lessonName = "No lesson found";
$current_section = "Prelude"; // Default to first section
$current_module = "The Basics"; // Default module

if ($user_id) {
    // Fetch progress if user is logged in
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $lessons_completed = $progress["lessons_completed"] ?? 0;
    $current_lesson = $progress["current_lesson"] ?? "Not Started";

    // Get lesson ID
    $sql0 = $pdo->prepare("SELECT lesson_id FROM user_progress WHERE user_id = ?");
    $sql0->execute([$user_id]);
    $lessonId = $sql0->fetch(PDO::FETCH_ASSOC)['lesson_id'] ?? null;

    // Get login status
    $sql = $pdo->prepare("SELECT is_logged_in FROM users WHERE id = ?");
    $sql->execute([$user_id]);
    $logged = (bool) $sql->fetchColumn();
}

// Section Mapping
$sections = ["Prelude", "Hello World", "File Navigation", "Checkpoint", "File Modifications", "Checkpoint", "Searching & Filtering", "File Modifications"];

if ($current_lesson >= 2 && $current_lesson < 3) {
    $current_section = $sections[0]; // Prelude
} elseif ($current_lesson === 3) {
    $current_section = $sections[1]; // Hello World
} elseif ($current_lesson >= 4 && $current_lesson < 10) {
    $current_section = $sections[2]; // File Navigation
} elseif ($current_lesson >= 10 && $current_lesson < 13) {
    $current_section = $sections[3]; // Checkpoint
} elseif ($current_lesson >= 13 && $current_lesson < 21) {
    $current_section = $sections[4]; // File Modifications
} elseif ($current_lesson >= 21 && $current_lesson < 28) {
    $current_section = $sections[5]; // Checkpoint
} elseif ($current_lesson >= 28 && $current_lesson < 37) {
    $current_section = $sections[6]; // Searching & Filtering
} elseif ($current_lesson >= 37) {
    $current_section = $sections[7]; // File Modifications
}

// Get Lesson Name if a valid lessonId exists
if ($lessonId) {
    $sql2 = $pdo->prepare("SELECT lesson_name FROM lessons WHERE id = ?");
    try {
        $sql2->execute([$lessonId]);
        $lessonName = $sql2->fetchColumn() ?? "No lesson found with ID: $lessonId";
    } catch (PDOException $e) {
        $lessonName = "Error fetching lesson: " . $e->getMessage();
    }
}

// Determine module
$modules = ["The Basics", "Networking", "Bash Scripting (Coming Soon)"];
if ($lessonId !== null) {
    if ($lessonId <= 60) {
        $current_module = $modules[0];
    } elseif ($lessonId <= 100) {
        $current_module = $modules[1];
    } elseif ($lessonId <= 150) {
        $current_module = $modules[2];
    }
}

// The file will return the user info in JSON
$response = [
    "username" => $username,
    "isLoggedIn" => $logged,
    "currentModule" => [
        "name" => $current_module,
        "currentSection" => $current_section,
        "lessonId" => $lessonId,
        "lessonName" => $lessonName  
    ],
    "modules" => [
        [
            "name" => "The Basics",
            "completed" => $lessons_completed,
            "total" => 40
        ],
        [
            "name" => "Networking",
            "completed" => 18,
            "total" => 21
        ],
        [
            "name" => "IDK",
            "completed" => 1,
            "total" => 17 
        ]
    ]
];

// Output JSON
echo json_encode($response);
