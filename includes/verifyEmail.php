<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
use \SendGrid\Mail\Mail;


if (!isset($_SESSION["user_email"])) {
    header("Location: signup.php");
    exit();
}
    $userEmail = $_SESSION["user_email"];

    //Check if verification code was recently sent (within last 60 seconds)
    $cooldownPeriod = 60; // seconds
    $currentTime = time();
    if (isset($_SESSION["last_code_sent"]) && 
    ($currentTime - $_SESSION["last_code_sent"]) < $cooldownPeriod) {
    
    // Code was sent recently, redirect to verification page
    header("Location: email_verification.php");
    exit();
    }
    // Check if we already have a valid code that hasn't expired (10 minutes)
    $codeExpiry = 600; // 10 minutes
    if (isset($_SESSION["email_code"]) && 
        isset($_SESSION["code_generated_at"]) &&
        ($currentTime - $_SESSION["code_generated_at"]) < $codeExpiry) {
    
        // Use existing valid code, redirect to verification
        echo "Error: Please wait 10 minutes for a new validation code.";
        header("Location: email_verification.php");
        exit();
    }

    function Generate_Code() : int {
        return rand(1000, 9999);
    }
    $code = Generate_Code();
    $_SESSION["email_code"] = $code;
    $_SESSION["code_generated_at"] = $currentTime;
    $_SESSION["last_code_sent"] = $currentTime;

    $apiKey = $_ENV["SENDGRID_API_KEY"];
    $sendgrid = new \SendGrid($apiKey);
    $email = new Mail();
    $email->setFrom("no-reply@linux-lab.live", "Linux Lab");
    $email->setSubject("Email Verification");
    $email->addTo($userEmail);
    $email->addContent("text/html", "Here Is Your Verification Code:<br><span style='font-size: 24px; font-weight: bold; color: #4CAF50;'>$code</span><br>If you didn't make this request you can ignore it.<br> - The Linux Lab Team");

    try {
    $response = $sendgrid->send($email);
    error_log("Email status code: " . $response->statusCode());
    header("Location: email_verification.php");
    exit();
}

   catch (Exception $e) {
        error_log("SendGrid Error: " . $e->getMessage());
        $_SESSION['verify_error'] = "Something went wrong sending the email.";
        exit();
    }

