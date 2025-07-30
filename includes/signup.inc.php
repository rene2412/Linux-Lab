<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
   $username = $_POST["username"];
   $email = $_POST["email"];  
   $pwd = $_POST["pwd"];


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
       if (is_username_too_long($username )) {
           $errors["invalid_username"] = "Username can't exceed past 20 characters";      
       }
       if (email_is_registered($pdo, $email)) {
           $errors["email_taken"] = "Email already registered. Please choose another!";       
       }


       if (is_passsword_valid($pwd) === false) {
           $errors["password_ invalid"] = "Invalid Password!";
       }


   if ($errors) {
       $_SESSION["errors_signup"] = $errors;
        header("Location: ../src/pages/login/signup.php");
        die();
       }
   //If vetting is good, then its ready to check if email is valid
   $_SESSION["pwd"] = $pwd;
   $_SESSION["user_email"] = $email;  
   $_SESSION["user_username"] = $username;
   header("Location: verifyEmail.php");
}
