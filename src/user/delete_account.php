<?php
require_once "validateForms.php";
require_once "../../includes/database.inc.php";
require_once "../../includes/signup_contr.inc.php";
session_start();

header("Content-Type: application/json");

$username = $_SESSION["user_username"];
$userId = $_SESSION["user_id"] ?? null;
$Success;
$Errors;

if (!$userId) {
    http_response_code(401);
    echo json_encode(["Error" => "Unauthorized"]);
    return;
}

Delete_Account($pdo, $userId);
$Success = "Account successfully deleted!";
require_once "logout.php"; // log user out

  //sending api
  echo json_encode([
    "Username: " => $username,
    "User Id: " => $userId,
    "Error Logs: " => $Errors,
    "Success Logs: " => $Success,
]);
