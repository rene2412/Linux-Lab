<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "user.php";

$guestlessonID = $_SESSION["guestLessonId"];
$lessonName = "The Command Line";
$current_section = "Prelude"; // Default to first section
$current_module = "The Basics"; // Default module

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
            "total" => 56
        ],
        [
            "name" => "Networking",
            "completed" => 0,
            "total" => 22
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
$_SESSION['guestBasics'] = $response; 
return $_SESSION['guestBasics']; 