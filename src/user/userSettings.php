<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

echo "User Settings<br>";
$username = $_SESSION["user_username"];
$userId = $_SESSION["user_id"];
echo "User: $username<br>ID: $userId<br>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $oldUsername = $_POST["old_username"];
   $newUsername = $_POST["new_username"];
   $oldEmail = $_POST["old_email"];
   $newEmail = $_POST["new_email"];
   //username validation
   $username = GetUsername($pdo, $userId);
   if (empty($oldUsername) || empty($newUsername)) {
    echo '<p style="color:red;">' . "Error: Input Can't Be Empty";
    return;
    }
   if ($username !== $oldUsername) {
    echo '<p style="color:red;">' . "Error: Username '$oldUsername' Not Found!";
    return;
    }
   if ($oldUsername === $newUsername) {
    echo '<p style="color:red;">' . "Error: New Username Can't Be The Same!";
    return;
    }
    if (Is_Username_Taken($pdo, $newUsername)) {
    echo '<p style="color:red;">' . "Error: $newUsername Is Taken! Please Choose Another";
    return;
    }
    if ($oldUsername !== $newUsername) {
        UpdateUsername($pdo, $userId, $newUsername);
        echo 'Username Updated!';
        return;
    }
    //email validation
   $email = GetEmail($pdo, $userId);
   echo "Email: $email<br>";
   if (empty($oldEmail) || empty($newEmail)) {
    echo '<p style="color:red;">' . "Error: Input Can't Be Empty";
    return;
    }
   if ($email !== $oldEmail) {
    echo '<p style="color:red;">' . "Error: Email '$oldEmail' Not Found!";
    return;
    }
   if ($oldEmail === $newEmail) {
    echo '<p style="color:red;">' . "Error: New Email Can't Be The Same!";
    return;
    }
    if (email_is_registered($pdo, $newEmail)) {
    echo '<p style="color:red;">' . "Error: $newEmail Is Taken! Please Choose Another";
    return;
    }
    //insert the new email
    if ($oldEmail !== $newEmail) {
        UpdateEmail($pdo, $userId, $newEmail);
        echo "E-Mail is updated!\n";
    } 
}