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

$lessons_completed = $progress ? $progress["lessons_completed"] : 0;
$current_lesson = $progress ? $progress["current_lesson"] : "Not Started";

$sql = $pdo->prepare("SELECT is_logged_in FROM users WHERE id = ?");
$sql->execute([$user_id]);
$logged = $sql->fetchColumn(); // No parameter needed
// The file will return the user info in JSON
$response = array(
    "current_lesson" => $current_lesson,
    "lessons_completed" => $lessons_completed,
    "logged" => $logged
);

// Output the JSON-encoded response
//echo json_encode($response);

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