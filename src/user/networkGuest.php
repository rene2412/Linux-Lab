<?php
require_once "user.php";

$guestlessonID = $_SESSION["guestLessonId"] ?? 1;
$lessonName = "Networking";
$current_section = "Intro To Networking"; // Default to first section
$current_module = "Networking"; // Default module

// The file will return the user info in JSON
$response = [
    "username" => $username,
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
            "total" => 65
        ],
        [
            "name" => "Networking",
            "completed" => 0,
            "total" => 21
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
$_SESSION['guestNetwork'] = $response;
exit;