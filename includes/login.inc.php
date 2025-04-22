<?php

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$username = $_POST["username"];
 	 	    $pwd = $_POST["pwd"];

    try {
        require_once 'database.inc.php';
        require_once 'login_contr.inc.php';	
        require_once 'login_model.inc.php';
		require_once 'login_view.inc.php';
		require_once '../src/user/user.php';
		$errors= [];
    
		if (is_input_empty($username, $pwd)) {
			 $errors["empty_input"] = "Fill In All Fields!";		
		}
		$result = GetUser($pdo, $username); 

		if (is_username_wrong($result)) {
			$errors["username_invalid"] = "Invalid Username Or Password!";

		}
		// Check if GetUser returned false (user not found)
        if (!is_username_wrong($result) === false) {
            $errors["username_invalid"] = "Invalid Username2 Or Password!";
		}

		 if (!password_verify($pwd, $result["pwd"])) {
				$errors["password_invalid"] = "Invalid Password!";
		}
		//require_once 'config_session.inc.php';
		session_start();
		if ($errors) {
			$_SESSION["errors_login"] = $errors;
			header("Location: ../src/pages/login/login.php");	
			die();
		}

		$newSessionId = session_create_id();		
	    $sessionId = $newSessionId . "_" . $result["id"];
		session_id($sessionId);
	
		$_SESSION["user_id"] = $result["id"];
		$_SESSION["user_username"] = htmlspecialchars($result["username"]);
		$_SESSION["last_regeneration"] = time();

        $stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);
		//on success, send the cookie and send user to the lesson page 
		// Convert the $response array to a JSON string
		$json_response = json_encode($response);

		// Set the cookie to expire in 30 days
		setcookie('user_info', $json_response, 0, "/");
		header('Location: ../src/pages/dashboard/dashboard.html');
		$pdo = null;
		$statement = null;
		die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}
	else {
		//header("Location: ../index.php");
		die();
	}

