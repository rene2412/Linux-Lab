<?php
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$username = $_POST["username"];
 	 	    $pwd = $_POST["pwd"];

    try {
        require_once 'database.inc.php';
        require_once 'login_contr.inc.php';	
        require_once 'login_model.inc.php';	
		$errors= [];
    
		if (is_input_empty($username, $pwd)) {
			 $errors["empty_input"] = "Fill In All Fields!";		
		}

		$result = GetUser($pdo, $username); 

		if (is_username_wrong($result)) {
			$errors["username_invalid"] = "Invalid Username!";
		}

		if (!password_verify($pwd, $result["pwd"])) {
				$errors["password_invalid"] = "Invalid Password!";
		}
			require_once 'config_session.inc.php';
		
		if ($errors) {
			$_SESSION["errors_login"] = $errors; 
		 	header("Location: ../index.php");	
			 die();
		}

		$newSessionId = session_create_id();		
	    $sessionId = $newSessionId . "_" . $result["id"];
		session_id($sessionId);
	
		$_SESSION["user_id"] = $result["id"];
		$_SESSION["user_username"] = htmlspecialchars($result["username"]);
		$_SESSION["last_regeneration"] = time();
		
		header("Location: ../index.php?login=success");
		//on success, send the user to the lesson page
		header('Location: ../src/pages/lesson_page/lesson.html');
		$pdo = null;
		$statement = null;
		die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}
	else {
		header("Location: ../index.php");
		die();
	}

