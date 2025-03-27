<?php
session_start();
require_once "../../includes/database.inc.php";
// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../src/pages/login/login.php"); // Redirect if not logged in
    exit();
}
$username = $_SESSION["user_username"]; // Get stored username
$user_id = $_SESSION["user_id"];


$stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
$stmt->execute([$user_id]);
$progress = $stmt->fetch(PDO::FETCH_ASSOC);

$lessons_completed = $progress ? $progress["lessons_completed"] : 0;
$current_lesson = $progress ? $progress["current_lesson"] : "Not Started";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>  <!-- Display username -->
    <p> You have completed <?php echo $lessons_completed; ?> lessons and left off at lesson <?php echo $current_lesson; ?></p>
    <p>Continue at <a href="../pages/lesson_page/lesson.html"><button>Lessons</button></a></p>
    <p>Log Out <a href="logout.php"><button>Logout</button></a></p>

</body>
</html>