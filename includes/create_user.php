<?php
session_start();
require_once "database.inc.php";
require_once "signup_contr.inc.php";

$username = $_SESSION["user_username"];	
$email = $_SESSION["user_email"];	
$pwd = $_SESSION["pwd"];

unset($_SESSION["pwd"]);

try {
        $result = create_user($pdo, $pwd, $username, $email);
		$newSessionId = session_create_id();		
	    $sessionId = $newSessionId . "_" . $result["id"];
		session_id($sessionId);
	 
		$_SESSION["user_id"] = $result["id"];
		$_SESSION["user_username"] = htmlspecialchars($result["username"]);
		$_SESSION["last_regeneration"] = time();
		$user_id = $_SESSION["user_id"];
		//for current module
		$sql = $pdo->prepare("INSERT INTO user_progress (user_id, lesson_id, lessons_completed, current_lesson, current_module) VALUES (?, ?, ?, ?, ?)");
		$sql->execute([$user_id, 0, 0, 0, 'The Basics']);
		//set user is logged
		$stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);

		if ($_SESSION["user_id"] !== null) {
			require_once 'cookies.inc.php';
			$json_response = json_encode($response);
			setcookie('user_info', $json_response, 0, "/"); // Expires when browser closes
		}
	 
	 header("Location: ../src/pages/dashboard/dashboard.html");	
	 $pdo = null;
	 $stmt = null;
     	 $pwd = null;	 
	 die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
