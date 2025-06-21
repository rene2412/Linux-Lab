<?php 
session_start();
require __DIR__ . '/../vendor/autoload.php';

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;

use \SendGrid\Mail\Mail;


if (isset($_SESSION["send_email"])) {

    $userEmail = $_SESSION["send_email"];
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    require_once "database.inc.php";

    $url = "https://linux-lab.live/includes/create_new_password.inc.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
    
    // SQL Queries
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die("Debug: SQL DELETE failed: " . implode(", ", $pdo->errorInfo()));
    } else {
        $stmt->execute([$userEmail]);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) 
    VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die("Debug: SQL INSERT failed: " . implode(", ", $pdo->errorInfo()));
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT); 
        $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);
             error_log("✅ INSERT executed");
    }

    // Sending the email
   // $mail = new PHPMailer(true);


    $email = new Mail();
    $email->setFrom("no-reply@linux-lab.live", "Linux Lab");
    $email->setSubject("Reset Your Password");
    $email->addTo($userEmail);
    $email->addContent("text/html", "Here is your reset link: <a href='$url'>$url</a>");   
    
    
    try {
    $response = $sendgrid->send($email);
    error_log("✅ Email status code: " . $response->statusCode());
    header("Location: email_sent.html");
    exit();
}

   catch (Exception $e) {
        error_log("SendGrid Error: " . $e->getMessage());
    }
}

