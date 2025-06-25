<?php
// Start output buffering to catch any warnings
ob_start();
session_start();
// Clear any warnings from session_start
ob_clean();
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
$lessonName = "The Command Line";
$current_section = "Prelude"; // Default to first section
$current_module = "The Basics"; // Default module
error_log("username: $username\n");
error_log("userID: $user_id\n");

if ($user_id === null) { 
    error_log($user_id === null 
    ? "→ Entering GUEST branch" 
    : "→ Entering LOGGED-IN branch, dbModule = $dbCurrentModule");


    //The file will return the user info in JSON
    $guestlessonID = $_SESSION["guestLessonId"] ?? 1;
    error_log("REQUEST METHOD: " . $_SERVER["REQUEST_METHOD"]);
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = trim(file_get_contents('php://input'));
        $_SESSION["input"] = $input;
        error_log("INPUT: $input");
        if ($input === "The Basics") {
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
            exit;
    }
    elseif ($input === "Networking") {
        $current_module = "Networking";
        $lessonName = "Networking";
        $current_section = "Intro To Networking"; // Default to first section
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
        exit;
        }
        else exit;
    }
}

if ($user_id) {
    // Fetch progress if user is logged in
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $lessons_completed = $progress["lessons_completed"] ?? 0;
    
    $current_lesson = $progress["current_lesson"] ?? "Not Started";

    // Fetch the network progress
    $stmt = $pdo->prepare("SELECT lessons_completed, current_lesson FROM network_user_progress WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $network_progress = $stmt->fetch(PDO::FETCH_ASSOC);
    $networking_lessons_completed = $network_progress["lessons_completed"] ?? 0;
    

    //update the lesson ID from the most previous user lesson entry
    $updateSql = $pdo->prepare("UPDATE user_progress up
    JOIN (
        SELECT user_id, lesson_id
        FROM user_lessons
        WHERE (user_id, completed_at) IN (
            SELECT user_id, MAX(completed_at)
            FROM user_lessons
            GROUP BY user_id
        )
    ) ul ON up.user_id = ul.user_id
    SET up.lesson_id = ul.lesson_id;
    ");   
    $updateSql->execute();

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
$sections = ["Prelude", "Hello World", "File Navigation", "Checkpoint - File Navigation", "File Modifications", "Checkpoint - File Modifations", "Searching & Filtering", "File Redirection", "Checkpoint- Searching, Filtering, ", "File Permissions", "Checkpoint - File Permissions"];

if ($current_lesson >= 2 && $current_lesson < 3) {
    $current_section = $sections[0]; // Prelude
} elseif ($current_lesson === 3) {
    $current_section = $sections[1]; // Hello World
} elseif ($current_lesson >= 4 && $current_lesson <=10) {
    $current_section = $sections[2]; // File Navigation
} elseif ($current_lesson >= 11 && $current_lesson <= 13) {
    $current_section = $sections[3]; // Checkpoint
} elseif ($current_lesson >= 14 && $current_lesson <= 21) {
    $current_section = $sections[4]; // File Modifications
} elseif ($current_lesson >= 22 && $current_lesson <= 28) {
    $current_section = $sections[5]; // Checkpoint - File Modifations
} elseif ($current_lesson >= 29 && $current_lesson <= 37) {
    $current_section = $sections[6]; // Searching & Filtering
} elseif ($current_lesson >= 38 && $current_lesson <= 40 ) {
    $current_section = $sections[7]; // File Redirection
}
elseif ($current_lesson >= 41 && $current_lesson <= 50) {
    $current_section = $sections[8]; // Checkpoint - Searching, Filtering, Redirection
}
elseif ($current_lesson >= 51 && $current_lesson <= 58) {
    $current_section = $sections[9]; // File Permissions
}
elseif ($current_lesson >= 59 && $current_lesson <= 64) {
    $current_section = $sections[10]; // Checkpoint - File Permissions
}
// Get Lesson Name if a valid lessonId exists
if ($lessonId) {
    $sql2 = $pdo->prepare("SELECT lesson_name FROM lessons WHERE id = ?");
    try {
        $sql2->execute([$lessonId]);
        $lessonName = $sql2->fetchColumn() ?? "The Command Line";
    } catch (PDOException $e) {
        $lessonName = "Error fetching lesson: " . $e->getMessage();
    }
}

// Determine module
$modules = ["The Basics", "Networking", "Bash Scripting (Coming Soon)"];
if ($lessonId !== null) {
    if ($lessonId <= 65) {
        $current_module = $modules[0];
    } elseif ($lessonId <= 100) {
        $current_module = $modules[1];
    } elseif ($lessonId <= 150) {
        $current_module = $modules[2];
    }
}

//load the user progress to load in the progress bar
$userProgress = "SELECT lesson_id FROM user_lessons WHERE user_id = ?";
        $stmt = $pdo->prepare($userProgress);
        $stmt->execute([$user_id]);
        $completedLessons = $stmt->fetchAll(PDO::FETCH_COLUMN);

//the lessons va will contain an array that has all the completed lesson ids
$everyLesson = "SELECT id, lesson_name FROM lessons";
$stmt4 = $pdo->query($everyLesson);
$everyLesson = $stmt4->fetchAll(PDO::FETCH_ASSOC);

$lessonStatus = [];
foreach ($everyLesson as $lesson) {
    $lesson_name = $lesson["lesson_name"];
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

function sendAPI($api) : array {
    global $username, $logged, $current_section, $lessonId, $lessonName, $lessonStatus;
    global $lessons_completed, $networking_lessons_completed;
    //The file will return the user info in JSON
    if ($api === "The Basics") {
    return [
        "username" => $username,
        "isLoggedIn" => $logged,
        "currentModule" => [
            "name" => "The Basics",
            "currentSection" => $current_section,
            "lessonId" => $lessonId,
            "lessonName" => $lessonName,
            "lessonStatus" => $lessonStatus
        ],
         "modules" => [
        [
            "name" => "The Basics",
            "completed" => $lessons_completed,
            "total" => 64
        ],
        [
            "name" => "Networking",
            "completed" => $networking_lessons_completed,
            "total" => 21
        ],
        [
            "name" => "Bash Scripting",
            "completed" => 0,
            "total" => 0 
                ]
            ]
        ];
    }
    if ($api === "Networking") {
        require_once "networkUser.php";
        $network = $_SESSION['networkAPI'];
        return $network;
    }
    else return ["Error" => "INVALID API"];
}   
error_log("→ GET handler, user_id = " . var_export($user_id, true));

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $guestInput = $_SESSION['input'] ?? "The Basics";
        error_log("Guest Input: $guestInput");
    if ($user_id === null) {
        if ($guestInput === "The Basics") {
            require_once "guest.php";
            $basics = $_SESSION['guestBasics'];
            echo json_encode($basics); 
            return;
      }
    elseif ($guestInput === "Networking") {
            require_once "networkGuest.php";
            $guestNetwork = $_SESSION['guestNetwork'];
            echo json_encode($guestNetwork);
            return;
      }
    }
    else {
     global $dbCurrentModule;
     //Get current module from database instead of hardcoding
      $stmt = $pdo->prepare("SELECT current_module FROM user_progress WHERE user_id = ?");
      $stmt->execute([$user_id]);
      $dbCurrentModule = $stmt->fetchColumn() ?? "The Basics";
      error_log("About to call sendAPI($dbCurrentModule)");
      $gigaAPI = sendAPI($dbCurrentModule);
      error_log("sendAPI returned: " . json_encode($gigaAPI));
      echo json_encode($gigaAPI);
      return;
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = trim(file_get_contents('php://input'));
    if (!$input) {
        error_log(json_encode($input)); 
        echo json_encode(["Error: => Invalid Input"]);   
        return;
}

    elseif ($input === "The Basics") {
        // UPDATE database with new module
        $stmt = $pdo->prepare("UPDATE user_progress SET current_module = ? WHERE user_id = ?");
        $stmt->execute(["The Basics", $user_id]);
        
        //The main API
        $stmt = $pdo->prepare("SELECT current_module FROM user_progress WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $dbCurrentModule = $stmt->fetchColumn() ?? "The Basics";

        //Return the API
        $gigaAPI = sendAPI($dbCurrentModule);
        echo json_encode($gigaAPI);
        return;
    }

    elseif ($input === "Networking" ) {
        // UPDATE database with new module
        $stmt = $pdo->prepare("UPDATE user_progress SET current_module = ? WHERE user_id = ?");
        $stmt->execute(["Networking", $user_id]);
        
        $stmt = $pdo->prepare("SELECT current_module FROM user_progress WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $dbCurrentModule = $stmt->fetchColumn() ?? "Networking";
    
        $gigaAPI = sendAPI($dbCurrentModule);
        echo json_encode($gigaAPI);
        return;
    }

    else {
        error_log(json_encode("Error: Invalid Post Input ")); 
        echo json_encode(["Error:  Invalid Post Input"]);
        }
    } 