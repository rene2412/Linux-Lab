<?php 
session_start();
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_SESSION["send_email"])) {
    $email = $_SESSION["send_email"];

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    require_once "database.inc.php";

    $url = "http://linux-lab.live/includes/create_new_password.inc.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
    $userEmail = $_SESSION["send_email"];
    
    // SQL Queries
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die("Debug: SQL DELETE failed: " . implode(", ", $pdo->errorInfo()));
    } else {
        $stmt->execute([$email]);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) 
    VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        die("Debug: SQL INSERT failed: " . implode(", ", $pdo->errorInfo()));
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT); 
        $stmt->execute([$email, $selector, $hashedToken, $expires]);
}

    // Sending the email
    $mail = new PHPMailer(true);

    try {

        // Server settings
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = 'linuxlab012@gmail.com';
        $mail->Password = 'ayfp eofz khas nmki'; 

        // Recipients
        $mail->setFrom($userEmail);
        $mail->addAddress($userEmail);

        // Content
        $mail->Subject = "Reset Your Password";
        $mail->Body = 'Here is your password reset link: </br>';
        $mail->Body .= '<a href="' . $url . '">' . $url . '</a></p>';

        $mail->send();
        header("Location: email_sent.html");
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
} else {
    //header("Location: ../index.php");
    exit();
}
