<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use GuzzleHttp\Client;

if (!isset($_SESSION["user_email"])) {
    header("Location: signup.php");
    exit();
}

$userEmail = $_SESSION["user_email"];

// Check cooldown (60s)
$cooldownPeriod = 60;
$currentTime = time();
if (isset($_SESSION["last_code_sent"]) &&
    ($currentTime - $_SESSION["last_code_sent"]) < $cooldownPeriod) {
    header("Location: email_verification.php");
    exit();
}

// Check if code still valid (10 min)
$codeExpiry = 600;
if (isset($_SESSION["email_code"]) &&
    isset($_SESSION["code_generated_at"]) &&
    ($currentTime - $_SESSION["code_generated_at"]) < $codeExpiry) {
    $_SESSION['verify_error'] = "Please wait 10 minutes for a new validation code.";
    header("Location: email_verification.php");
    exit();
}

// Generate 4-digit code
function Generate_Code(): int {
    return rand(1000, 9999);
}

$code = Generate_Code();
$_SESSION["email_code"] = $code;
$_SESSION["code_generated_at"] = $currentTime;
$_SESSION["last_code_sent"] = $currentTime;

// ==== Resend API ====
$client = new Client([
    'base_uri' => 'https://api.resend.com/',
    'headers' => [
        'Authorization' => 'Bearer ' . $_ENV['RESEND_API_KEY'],
        'Content-Type' => 'application/json',
    ]
]);

$htmlBody = '
<!DOCTYPE html>
<html>
  <body style="margin:0; font-family: Arial, sans-serif; background-color:#0b0f19; color:#fff;">
    <div style="max-width:600px; margin:auto; padding:30px; background:#111827; border-radius:12px; text-align:center;">
      <img src="https://freepngimg.com/thumb/penguin/75902-tux-kernel-racer-penguins-linux-penguin.png"
           alt="Linux Lab Mascot" style="width:120px; margin-bottom:20px;">
      <h1 style="color:#00ff9c; margin-bottom:10px;">Verify Your Email</h1>
      <p style="font-size:16px; color:#e5e7eb;">
        Use the code below to verify your Linux Lab account:
      </p>
      <div style="font-size:24px; font-weight:bold; color:#4CAF50; margin:20px 0;">
        ' . $code . '
      </div>
      <p style="font-size:14px; color:#9ca3af;">
        If you did not request this, you can ignore this email.<br>
        - The Linux Lab Team
      </p>
    </div>
  </body>
</html>
';

try {
    $response = $client->post('emails', [
        'body' => json_encode([
            "from" => "Linux Lab <no-reply@linux-lab.live>",
            "to" => $userEmail,
            "subject" => "Verify Your Linux Lab Email",
            "html" => $htmlBody,
            "text" => "Your verification code is: $code"
        ])
    ]);

    header("Location: email_verification.php");
    exit();

} catch (\Exception $e) {
    error_log("Resend Error: " . $e->getMessage());
    $_SESSION['verify_error'] = "Something went wrong sending the email.";
    header("Location: email_verification.php");
    exit();
}

