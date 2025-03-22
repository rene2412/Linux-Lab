<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
	$username = $_POST["username"];	
    $email = $_POST["email"];	
    $pwd = $_POST["pwd"];

    try {
        require_once 'database.inc.php';
//		require_once 'config_session.inc.php';
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
		 header("Location: ../src/pages/login/login.php");	
		 die();
		}

	 create_user($pdo, $pwd, $username, $email);
	 header("Location: ../src/pages/landing_page/landing_page.html");
	 $pdo = null;
	 $stmt = null;	 
	 die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
    }
}