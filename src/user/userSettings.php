<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

echo json_encode("User Settings");
$username = $_SESSION["user_username"];
$userId = $_SESSION["user_id"];
echo json_encode ("User: $username<br>ID: $userId");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formType = $_POST["form_type"] ?? "";
   //username validation
    if ($formType === "change_username") { 
        $oldUsername = $_POST["old_username"];
        $newUsername = $_POST["new_username"];
   $username = GetUsername($pdo, $userId);
   if (empty($oldUsername) || empty($newUsername)) {
    echo json_encode ("Error: Username Input Can't Be Empty");
    return;
    }
   if ($username !== $oldUsername) {
    echo json_encode ("Error: Username '$oldUsername' Not Found!");
    return;
    }
   if ($oldUsername === $newUsername) {
    echo json_encode ("Error: New Username Can't Be The Same!");
    return;
    }
    if (Is_Username_Taken($pdo, $newUsername)) {
    echo json_encode ("Error: $newUsername Is Taken! Please Choose Another");
    return;
    }
    if (is_username_too_long($newUsername)) {
    echo json_encode ("Error: Username Is Too Long! Stay Within 15 Characters");
    return;
    }
    if ($oldUsername !== $newUsername) {
        UpdateUsername($pdo, $userId, $newUsername);
        echo json_encode ("Success: Username Updated!");
        //log user out
        require_once "logout.php";
        return;
    }
}
    if ($formType === "change_email") {        
        $oldEmail = $_POST["old_email"];
        $newEmail = $_POST["new_email"];
        //email validation
        $email = GetEmail($pdo, $userId);
        echo json_encode ("Email: $email");

      if (empty($oldEmail) || empty($newEmail)) {
        echo json_encode("Error: Email Input Can't Be Empty");
        return;
     }
      if ($email !== $oldEmail) {
         echo json_encode("Error: Email '$oldEmail' Not Found!");
         return;
    }
      if ($oldEmail === $newEmail) {
        echo json_encode("Error: New Email Can't Be The Same!");
        return;
    }
      if (email_is_registered($pdo, $newEmail)) {
        echo json_encode("Error: $newEmail Is Taken! Please Choose Another");
        return;
    }
    //insert the new email
      if ($oldEmail !== $newEmail) {
         UpdateEmail($pdo, $userId, $newEmail);
         echo json_encode("Success: E-Mail is updated!");
         return;
        } 
    }
    //delete the account (rip)
    if ($formType === "delete_account") {
        Delete_Account($pdo, $userId);
        echo json_encode("Account Succesfully Deleted, Goodbye!");
        require_once "logout.php";
        return;
    }
    else {
        echo json_decode("Error Invalid Form!");
        return;
    }
}