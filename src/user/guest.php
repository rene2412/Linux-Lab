<?php
session_start();
require_once "../../includes/database.inc.php";



$sql = "SELECT user_lessons FROM users WHERE id = ?";
$user_lessons;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest User </title>
</head>
<body>
    <p>Hello User, you have completed: </p>
</body>
