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

    function Generate_Code() : int {
        return rand(1000, 9999);
    }
    $code = Generate_Code();
    $_SESSION["email_code"] = $code;
    echo error_log("CODE: $code");

    $apiKey = $_ENV["SENDGRID_API_KEY"];
    $sendgrid = new \SendGrid($apiKey);
    $email = new Mail();
    $email->setFrom("no-reply@linux-lab.live", "Linux Lab");
    $email->setSubject("Email Verification");
    $email->addTo($userEmail);
    $email->addContent("text/html", "Here Is Your Verification Code:<br><span style='font-size: 24px; font-weight: bold; color: #4CAF50;'>$code</span>");

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

