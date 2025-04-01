<?php
session_start();
// Set the content type to JSON
header('Content-Type: application/json');
require_once "../../includes/database.inc.php";

$username = $_SESSION["user_username"]; // Get stored username
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
$stmt->execute([$user_id]);
$progress = $stmt->fetch(PDO::FETCH_ASSOC);


$sql0 = $pdo->prepare("SELECT lesson_id FROM user_progress WHERE user_id = ?");
$sql0->execute([$user_id]);
$lessonId = $sql0->fetch(PDO::FETCH_ASSOC)['lesson_id'];

$lessons_completed = $progress ? $progress["lessons_completed"] : 0;
$current_lesson = $progress ? $progress["current_lesson"] : "Not Started";

$sql = $pdo->prepare("SELECT is_logged_in FROM users WHERE id = ?");
$sql->execute([$user_id]);
$logged = $sql->fetchColumn(); // No parameter needed

$sections = ["Prelude", "Hello World", "File Navigation", "Checkpoint", "File Modifications", "Checkpoint", "Searching & Filtering", "File Modifications"];

if ($current_lesson >= 2 && $current_lesson < 3) {
    $current_section = $sections[0]; // Prelude
}
elseif ($current_lesson === 3) {
    $current_section = $sections[1]; // Hello World
}
elseif ($current_lesson >= 4 && $current_lesson < 10) {
    $current_section = $sections[2]; // File Navigation
}
elseif ($current_lesson >= 10 && $current_lesson < 13) {
    $current_section = $sections[3]; // Checkpoint
}
elseif ($current_lesson >= 13 && $current_lesson < 21) {
    $current_section = $sections[4]; // File Modifications
}
elseif ($current_lesson >= 21 && $current_lesson < 28) {
    $current_section = $sections[5]; // Checkpoint
}
elseif ($current_lesson >= 28 && $current_lesson < 37) {
    $current_section = $sections[6]; // Searching & Filtering
}
elseif ($current_lesson >= 37) {
    $current_section = $sections[7]; // File Modifications
}


$sql2 = $pdo->prepare("SELECT lesson_name FROM lessons WHERE id = ?");

try {
    $sql2->execute([$lessonId]);
    $lessonName = $sql2->fetchColumn();
    
    if ($lessonName === false) {
        // No result found
        $lessonName = "No lesson found with ID: " . $lessonId;
    }
} catch (PDOException $e) {
    // Query error
    $lessonName = "Error fetching lesson: " . $e->getMessage();
}
$module = ["The Basics", "Networking", "Bash Scipting (Coming Soon)"];
if ($lessonId <= 60) {
    $current_module = $module[0];
}
elseif ($lessonId <= 100) {
    $current_module = $module[1];
}
elseif ($lessonId <= 150) {
    $current_module = $module[2];
}


// The file will return the user info in JSON
$response = array(
    "username" => $username,
    "isLoggedIn" => $logged,
    "currentModule" => array(
        "name" => $current_module,
        "currentSection" => $current_section,
        "lessonId" => $lessonId,
        "lessonName" => $lessonName  
    ),
    "modules" => array(
            "name" => "The Basics",
            "completed" => $lessons_completed,
            "total" => 40
    )
);

// Convert to JSON with pretty printing
echo json_encode($response, JSON_PRETTY_PRINT);

/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>  <!-- Display username -->
    <p>User Logged In Status: <?php  echo $logged; ?></p>
    <p> You have completed <?php echo $lessons_completed; ?> lessons and left off at lesson <?php echo $current_lesson; ?></p>
    <p>Continue at <a href="../pages/lesson_page/lesson.html"><button>Lessons</button></a></p>
    <p>Log Out <a href="logout.php"><button>Logout</button></a></p>
    
</body>
</html>
*/