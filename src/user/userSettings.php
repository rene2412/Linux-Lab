<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

$username = $_SESSION["user_username"];
$userId = $_SESSION["user_id"];
$Errors = [];
$Success = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formType = $_POST["form_type"] ?? "";
   //username validation
    if ($formType === "change_username") { 
        $oldUsername = $_POST["old_username"];
        $newUsername = $_POST["new_username"];
   $username = GetUsername($pdo, $userId);
   if (empty($oldUsername) || empty($newUsername)) {
    $Errors .= "Error: Username Input Can't Be Empty";
    }
   if ($username !== $oldUsername) {
    $Errors .= "Error: Username '$oldUsername' Not Found!";
    }
   if ($oldUsername === $newUsername) {
    $Errors .= "Error: New Username Can't Be The Same!";
    }
    if (Is_Username_Taken($pdo, $newUsername)) {
    $Errors .= "Error: $newUsername Is Taken! Please Choose Another";
    }
    if (is_username_too_long($newUsername)) {
    $Errors .= "Error: Username Is Too Long! Stay Within 15 Characters";
    }
    if ($oldUsername !== $newUsername) {
        UpdateUsername($pdo, $userId, $newUsername);
        $Success .= "Success: Username Updated!";
        //log user out
        require_once "logout.php";
    }
}
    if ($formType === "change_email") {        
        $oldEmail = $_POST["old_email"];
        $newEmail = $_POST["new_email"];
        //email validation
        $email = GetEmail($pdo, $userId);

      if (empty($oldEmail) || empty($newEmail)) {
        $Errors .= "Error: Email Input Can't Be Empty";
     }
      if ($email !== $oldEmail) {
         $Errors .= "Error: Email '$oldEmail' Not Found!";
    }
      if ($oldEmail === $newEmail) {
        $Errors .= "Error: New Email Can't Be The Same!";   
    }
      if (email_is_registered($pdo, $newEmail)) {
        $Errors .= "Error: $newEmail Is Taken! Please Choose Another";
    }
    //insert the new email
      if ($oldEmail !== $newEmail) {
         UpdateEmail($pdo, $userId, $newEmail);
         $Success .= "Success: E-Mail is updated!";
        } 
    }
    //delete the account (rip)
    if ($formType === "delete_account") {
        Delete_Account($pdo, $userId);
        $Success .= "Account Succesfully Deleted, Goodbye!";
        require_once "logout.php";
    }
    else {
        $Errors .= "Error Invalid Form!";
    }
    //sending api
    echo json_encode([
        "Username: " => $username,
        "User Id: " => $userId,
        "Error Logs: " => $Errors,
        "Success Logs: " => $Success,
    ]);
}