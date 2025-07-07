<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Set the content type to JSON
header('Content-Type: application/json');
require_once "../../includes/database.inc.php";
error_reporting(E_ALL & ~E_WARNING); 
global $pdo;

$username = $_SESSION["user_username"] ?? null; // Get stored username
$user_id = $_SESSION["user_id"] ?? null;
$logged = false; // Default to false for guests

$lessonId = 1;
$lessons_completed = 0;
$current_lesson = "Not Started";
$lessonName = "Networking";
$current_section = "Intro To Networking"; // Default to first section
$current_module = "Networking"; // Default module

if ($user_id === null) { //&& $_SERVER["REQUEST_METHOD"] === "POST") {
    //The file will return the user info in JSON
    $guestlessonID = $_SESSION["guestLessonId"];
    error_log(json_encode("Guest Lesson ID: $guestlessonID"));
        //The main API
        $response = [
            "username" => "Guest",
            "isLoggedIn" => false,
            "currentModule" => [
                "name" => $current_module,
                "currentSection" => $current_section,
                "lessonId" => $guestlessonID,
                "lessonName" => $lessonName,
                "lessonStatus" => false
                ],
            "modules" => [
                [
                    "name" => "The Basics",
                    "completed" => 0,
                    "total" => 50
                ],
                [
                    "name" => "Networking",
                    "completed" => 0,
                    "total" => 40
                ],
                [
                    "name" => "Bash Scripting",
                    "completed" => 0,
                    "total" => 0 
                    ]
                ]
            ];
        echo json_encode($response);
        error_log(json_encode($response)); 
        return;
}
if ($user_id) {
    // Fetch 'Networking' progress if user is logged in
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM network_user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $network_progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $networking_lessons_completed = $network_progress["lessons_completed"] ?? 0;
    $current_lesson = $network_progress["current_lesson"] ?? "Not Started";
    
    // Fetch 'The Basics' progress if user is logged in
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $lessons_completed = $progress["lessons_completed"] ?? 0;
    $basics_current_lesson = $progress["current_lesson"] ?? "Not Started";


    //update the lesson ID from the most previous user lesson entry
    $updateSql = $pdo->prepare("UPDATE network_user_progress up
    JOIN (
        SELECT user_id, lesson_id
        FROM network_user_lessons
        WHERE (user_id, completed_at) IN (
            SELECT user_id, MAX(completed_at)
            FROM network_user_lessons
            GROUP BY user_id
        )
    ) ul ON up.user_id = ul.user_id
    SET up.lesson_id = ul.lesson_id;
    ");   
    $updateSql->execute();

    // Get lesson ID
    $sql0 = $pdo->prepare("SELECT lesson_id FROM network_user_progress WHERE user_id = ?");
    $sql0->execute([$user_id]);
    $lessonId = $sql0->fetch(PDO::FETCH_ASSOC)['lesson_id'] ?? null;

    // Get login status
    $sql = $pdo->prepare("SELECT is_logged_in FROM users WHERE id = ?");
    $sql->execute([$user_id]);
    $logged = (bool) $sql->fetchColumn();

}

// Section Mapping
$sections = ["Intro To Networking", "IP Addresses", "Connections", "Checkpoint - The Internet, Ip addresses, and Connections", "Transferring Data"];

if ($current_lesson == 1) {
    $current_section = $sections[0];
} elseif ($current_lesson >= 2 && $current_lesson <= 3) {
    $current_section = $sections[1]; 
} elseif ($current_lesson >= 4 && $current_lesson <= 8) {
    $current_section = $sections[2];
} elseif ($current_lesson >= 9 && $current_lesson <= 12) {
    $current_section = $sections[3];
} elseif ($current_lesson >= 13) {
    $current_section = $sections[4];
}
// Get Lesson Name if a valid lessonId exists
if ($lessonId) {
    $sql2 = $pdo->prepare("SELECT title FROM networking_lessons WHERE id = ?");
    try {
        $sql2->execute([$lessonId]);
        $lessonName = $sql2->fetchColumn() ?? "The Command Line";
    } catch (PDOException $e) {
        $lessonName = "Error fetching lesson: " . $e->getMessage();
    }
}

//load the user progress to load in the progress bar
$userProgress = "SELECT lesson_id FROM network_user_lessons WHERE user_id = ?";
        $stmt = $pdo->prepare($userProgress);
        $stmt->execute([$user_id]);
        $completedLessons = $stmt->fetchAll(PDO::FETCH_COLUMN);

//the lessons va will contain an array that has all the completed lesson ids
$everyLesson = "SELECT id, title FROM networking_lessons";
$stmt4 = $pdo->query($everyLesson);
$everyLesson = $stmt4->fetchAll(PDO::FETCH_ASSOC);

$lessonStatus = [];
foreach ($everyLesson as $lesson) {
    $lesson_name = $lesson["title"];
    $lesson_id = $lesson["id"];
    $found = false;

    foreach ($completedLessons as $completed_id) {
        if ($lesson_id === $completed_id) {
            $found = true;
            break;
        }
    }
    $lessonStatus[$lesson_name] = $found;
}
// The file will return the user info in JSON
$response = [
    "username" => $username,
    "isLoggedIn" => $logged,
    "currentModule" => [
        "name" => "Networking",
        "currentSection" => $current_section,
        "lessonId" => $lessonId,
        "lessonName" => $lessonName,
        "lessonStatus" => $lessonStatus
        ],
    "modules" => [
        [
            "name" => "The Basics",
            "completed" => $lessons_completed,
            "total" => 50
        ],
        [
            "name" => "Networking",
            "completed" => $networking_lessons_completed,
            "total" => 30
        ],
        [
            "name" => "Bash Scripting",
            "completed" => 0,
            "total" => 0 
            ]
        ]
    ];

error_log("Lesson ID: " . $lessonId);
error_log("Current Lesson: " . $current_lesson);
error_log(json_encode($response));  // This will output the API response for debugging purposes.
$_SESSION['networkAPI'] = $response;
return $_SESSION['networkAPI'];