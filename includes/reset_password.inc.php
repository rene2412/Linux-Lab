<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {  
        $email = $_POST["email"];
        try {
            require_once "database.inc.php";
            require_once "reset_password.contr.php";
            require_once "reset_password_model.inc.php";
            $errors = [];

            if (is_input_empty($email)) {
                $errors["empty_input"] = "Fill In The Field";
            }

            if (is_email_valid($email) === false) {
                $errors["email_invalid"] = "Invalid Email Format";
            }
            
            if (email_is_registered($pdo, $email) === false) {
                $errors["invalid_email"] = "Email Is Not Registered";
            }

            require_once "config_session.inc.php";

            if ($errors) {
                $_SESSION["errors_reset_password"] = $errors; 
                header("Location: reset_info.inc.php");	
                exit();
            } else {
                $_SESSION["send_email"] = $email;
                header("Location: send_email.inc.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Caught exception: " . $e->getMessage();
        }
   }
   else {
        echo "Request is invalid.";
    }
