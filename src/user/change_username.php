<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

$username = $_SESSION["user_username"];
$userId = $_SESSION["user_id"];
$Errors = [];
$Success = [];
if (!$userId) {
    echo json_encode(["Error" => "Invalid User"]);
    return;
}
header("Content-Type: application/json");
$input = json_decode(file_get_contents("php://input"), true);

   $oldUsername = $input["old_username"] ?? "";
   $newUsername = $input["new_username"] ?? "";
   $username = Get_Username($pdo, $userId);
   
   if (empty($oldUsername) || empty($newUsername)) {
    $Errors[] = "Error: Username Input Can't Be Empty";
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
    }
   if ($username !== $oldUsername) {
    $Errors[] = "Error: Username '$oldUsername' Not Found!";
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
    }
   if ($oldUsername === $newUsername) {
    $Errors[] = "Error: New Username Can't Be The Same!";
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
    }
    if (Is_Username_Taken($pdo, $newUsername)) {
    $Errors[] = "Error: $newUsername Is Taken! Please Choose Another";
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
    }
    if (is_username_too_long($newUsername)) {
    $Errors [] = "Error: Username Is Too Long! Stay Within 15 Characters";
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
    return;
    }
    if ($oldUsername !== $newUsername) {
        UpdateUsername($pdo, $userId, $newUsername);
        $Success[] = "Success: Username Updated!";
        $username = $newUsername;
    Send_Rest_API($username, $userId, $email, $Errors, $Success);
        //log user out
        require_once "logout.php";
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