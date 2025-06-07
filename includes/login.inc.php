<?php

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$username = $_POST["username"];
 	 	    $pwd = $_POST["pwd"];

    try {
        require_once 'database.inc.php';
        require_once 'login_contr.inc.php';	
        require_once 'login_model.inc.php';
		require_once 'login_view.inc.php';

		$errors= [];
    
		if (is_input_empty($username, $pwd)) {
			 $errors["empty_input"] = "Fill In All Fields!";		
		}
		$result = GetUser($pdo, $username); 

		if (is_username_wrong($result)) {
			$errors["username_invalid"] = "Invalid Username Or Password!";

		}
		 if (!password_verify($pwd, $result["pwd"])) {
				$errors["password_invalid"] = "Invalid Password!";
		}
		ini_set('session.gc_maxlifetime', 7200); // 2 hours
		session_set_cookie_params([
			'lifetime' => 0, // session cookie (dies on browser close)
			'path' => '/',
			'domain' => '', 
			'secure' => false,
			'httponly' => true,
			'samesite' => 'Lax'
		]);
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
		if ($_SESSION["user_id"] !== null) {
			require_once 'cookies.inc.php';
			$json_response = json_encode($response);
			setcookie('user_info', $json_response, time() + 3600 , "/"); // Expires when browser closes
		}
		header('Location: ../src/pages/dashboard/dashboard.html');
		$pdo = null;
		$statement = null;
		die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}
	else {
		die();
	}

