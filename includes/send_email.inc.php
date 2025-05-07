<?php 
session_start();
echo "Debug: Starting send_email.inc.php<br>";
echo "Debug: Session file included<br>";
require __DIR__ . '/../vendor/autoload.php';
echo "Debug: PHPMailer loaded<br>";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_SESSION["send_email"])) {
    echo "Debug: Session variable 'send_email' is set<br>";
    $email = $_SESSION["send_email"];
    echo "Debug: Email is $email<br>";

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    echo "Debug: Generated selector and token<br>";

    $url = "http://localhost/Linux-Lab/includes/create_new_password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

    require "reset_password_database.inc.php";
    // SQL Queries
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $statement = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        die("Debug: SQL DELETE failed: " . mysqli_error($connection));
    } else {
        echo "Debug: SQL DELETE prepared<br>";
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) 
            VALUES (?, ?, ?, ?);";
    $statement = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        die("Debug: SQL INSERT failed: " . mysqli_error($connection));
    } else {
        echo "Debug: SQL INSERT prepared<br>";
        $hashedToken = password_hash($token, PASSWORD_DEFAULT); 
        mysqli_stmt_bind_param($statement, "ssss", $email, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($statement);
    }

    mysqli_stmt_close($statement);
    echo "Debug: SQL operations completed<br>";

    // Sending the email
    $mail = new PHPMailer(true);

    try {
        echo "Debug: Starting email setup<br>";

        // Server settings
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = "hrene2412@gmail.com";
        $mail->Password = "copv qlgy napt bcvo";


        // Recipients
        $mail->setFrom('hrene2412@gmail.com');
        $mail->addAddress($email);

        // Content
        $mail->Subject = "Reset Your Password";
        $mail->Body = 'Here is your password reset link: </br>';
        $mail->Body .= '<a href="' . $url . '">' . $url . '</a></p>';

        $mail->send();
        echo "Email sent successfully to $email.<br>";
        echo "Redirecting to sign up page, one moment";
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Debug: Session variable 'send_email' not set<br>";
    header("Location: ../index.php");
    exit();
}
