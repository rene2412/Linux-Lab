<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../../../includes/database.inc.php";
require '../../../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Read the raw JSON from the input stream
    $json = file_get_contents('php://input');
    
    // Decode it into a PHP array or object
    $data = json_decode($json, true); 

    $name = $data['name'];
    $email = $data['email'];
    $message = $data['message'];
    //echo json_encode(["name"=> $name, "email" => $email, "message" => $message]);

    $mail = new PHPMailer(true);

try {
    // SMTP Setup
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Username = 'linuxlab012@gmail.com';
    $mail->Password = 'ayfp eofz khas nmki'; 

    // Sender/Recipient
    $mail->setFrom($email, $name); 
    $mail->addAddress('linuxlab012@gmail.com'); 

    // Email Content
    $mail->isHTML(false);
    $mail->Subject = "New Contact Message from $name";
    $mail->Body = "You received a message from $name <$email>\n\n$message";

    $mail->send();
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "fail", "error" => $mail->ErrorInfo]);
}


}
