<?php 
session_start();
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use GuzzleHttp\Client;

if (isset($_SESSION["send_email"])) {

    $userEmail = $_SESSION["send_email"];
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    require_once "database.inc.php";

    $url = "https://linux-lab.live/includes/create_new_password.inc.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

    // Check existing request
    $sql = "SELECT * FROM pwdReset WHERE pwdResetEmail = ? AND pwdResetExpires > ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userEmail, date("U")]);
    $existing = $stmt->fetch();
    if ($existing) {
        header("Location: email_sent.html");
        exit();
    }

    // Delete old token
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userEmail]);

    // Insert new token
    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $hashedToken = password_hash($token, PASSWORD_DEFAULT); 
    $stmt->execute([$userEmail, $selector, $hashedToken, $expires]);

    // ==== Resend API ====
    $client = new Client([
        'base_uri' => 'https://api.resend.com/',
        'headers' => [
            'Authorization' => 'Bearer ' . $_ENV['RESEND_API_KEY'],
            'Content-Type' => 'application/json',
        ]
    ]);

    $data = [
        "from" => "Linux Lab <no-reply@linux-lab.live>",
        "to" => $userEmail,
        "subject" => "Reset Your Password",
        "html" => '
        <!DOCTYPE html>
        <html>
          <body style="margin:0; font-family: Arial, sans-serif; background-color:#0b0f19; color:#fff;">
            <div style="max-width:600px; margin:auto; padding:30px; background:#111827; border-radius:12px; text-align:center;">
              <img src="https://freepngimg.com/thumb/penguin/75902-tux-kernel-racer-penguins-linux-penguin.png" 
                   alt="Linux Lab Mascot" style="width:120px; margin-bottom:20px;">
              <h1 style="color:#00ff9c; margin-bottom:10px;">Reset Your Password</h1>
              <p style="font-size:16px; color:#e5e7eb;">
                Click the button below to reset your Linux Lab password.
              </p>
              <a href="' . $url . '" 
                 style="display:inline-block; margin-top:20px; padding:14px 24px; background:#00ff9c; color:#000; font-weight:bold; text-decoration:none; border-radius:8px;">
                Reset Password
              </a>
              <p style="font-size:12px; color:#9ca3af; margin-top:40px;">
                Linux Lab — Learn Linux the real way<br>
                linux-lab.live
              </p>
            </div>
          </body>
        </html>'
    ];

    $response = $client->post('emails', [
        'body' => json_encode($data)
    ]);

    header("Location: email_sent.html");
    exit();  
}

