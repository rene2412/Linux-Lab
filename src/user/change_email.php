<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$userId = $_SESSION["user_id"] ?? null;
$Errors = [];
$Success = [];
$username = $_SESSION["user_username"] ?? null;;

if (!$userId) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    return;
}

$oldEmail = $input["old_email"] ?? "";
$newEmail = $input["new_email"] ?? "";
$currentEmail = GetUserEmail($pdo, $userId);
$email = "";
if (empty($oldEmail) || empty($newEmail)) {
    $Errors[] = "Error: Email Input Can't Be Empty";
    $email = $oldEmail;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
}
  if ($currentEmail !== $oldEmail) {
     $Errors[] = "Error: Email '$oldEmail' Not Found!";
    $email = $oldEmail;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
  }
  if ($oldEmail === $newEmail) {
    $Errors[] = "Error: New Email Can't Be The Same!";   
    $email = $oldEmail;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
  }
  if (email_is_registered($pdo, $newEmail)) {
    $Errors[] = "Error: $newEmail Is Taken! Please Choose Another";
    $email = $oldEmail;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
  }
//insert the new email
  if ($oldEmail !== $newEmail) {
     UpdateEmail($pdo, $userId, $newEmail);
     $Success[] = "Success: E-Mail is updated!";
     $email = $newEmail;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
     return;
    } 

function Send_Rest_API($username, $userId, $email, $Errors, $Success) {
  echo json_encode([
      "Username: " => $username,
      "User Id: " => $userId,
      "Email:" => $email,
      "Error Logs: " => $Errors,
      "Success Logs: " => $Success,
  ]);
}