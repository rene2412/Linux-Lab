<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["code"]) || !isset($_SESSION["email_code"])) {
        $_SESSION["verify_error"] = "Verification code missing. Please try again.";
        header("Location: email_verification.php");
        exit();
    }

    $userCode = trim($_POST["code"]);
    $realCode = $_SESSION["email_code"];
    
    if ((int)$userCode === (int)$realCode) {
        unset($_SESSION["email_code"]);
        //finally we can create the user
        header("Location: create_user.php");
        exit();
    }
    else {
        $_SESSION["verify_error"] = "Invalid Code. Please Try Again";
        header("Location: email_verification.php");
        exit();
    }
}
    else { 
        header("Location: email_verification.php");
        exit();
    }
