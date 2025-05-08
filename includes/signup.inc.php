<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
	$username = $_POST["username"];	
    $email = $_POST["email"];	
    $pwd = $_POST["pwd"];

    try {
        require_once 'database.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';	
	 
		$errors = [];
    
		if (is_input_empty($username, $pwd, $email)) {
		$errors["empty_input"] = "Fill In All Fields!";		
		}

		if (!is_email_valid($email)) {
            $errors["invalid_email"] = "Invalid E-Mail!";		
        }
    
        if (username_is_taken($pdo, $username)) {
            $errors["username_taken"] = "Username is taken. Please choose another!";		
        }
    
        if (email_is_registered($pdo, $email)) {
            $errors["email_taken"] = "Email already registered. Please choose another!";		
        }

		if (is_passsword_valid($pwd) === false) {
			$errors["password_ invalid"] = "Invalid Password!";
		}

		session_start();
	if ($errors) {
		$_SESSION["errors_signup"] = $errors; 
		 header("Location: ../src/pages/login/signup.php");	
		 die();
		}
	    $result = create_user($pdo, $pwd, $username, $email);
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
			setcookie('user_info', $json_response, 0, "/"); // Expires when browser closes
		}
	 header("Location: ../src/pages/landing_page/landing_page.html");
	 $pdo = null;
	 $stmt = null;	 
	 die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}