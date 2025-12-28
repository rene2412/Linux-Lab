<?php 
session_start();
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION["send_email"])) {

    $userEmail = $_SESSION["send_email"];
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    require_once "database.inc.php";

    $url = "https://linux-lab.live/includes/create_new_password.inc.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;
   
    $sql = "SELECT * FROM pwdReset WHERE pwdResetEmail = ? AND pwdResetExpires > ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userEmail, date("U")]);
    $existing = $stmt->fetch();
if ($existing) {
    // Already requested and still valid, don’t send another
    header("Location: email_sent.html");
    exit();
}
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
             error_log("INSERT executed");
    }
    $email = new PHPMailer(true);
    try {
        $email->isSMTP();
        $email->Host = "smtp.gmail.com";
        $email->SMTPAuth = true;
        $email->Username = "linuxlab012@gmail.com";
        $email->Password = $_ENV['SMTP_PASSWORD'];
        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $email->Port = 587;
	
	$email->SMTPDebug = 2;
	$email->Debugoutput = 'error_log';
	$email->Timeout = 10;
		

        $email->setFrom("linuxlab012@gmail.com", "Linux Lab");
        $email->addAddress($userEmail);
        $email->isHTML(true);
        $email->Subject = "Reset Your Password";
        $email->Body = "Here is your reset link: <a href='$url'>$url</a>";   
        $email->send();
        header("Location: email_sent.html");
        exit();
    }
   catch (Exception $e) {
        error_log("PHP Mailer Error: " . $email->ErrorInfo);
    }
}


