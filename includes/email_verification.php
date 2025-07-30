<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<h1>Email Verification</h1>
<h2>Please Check Your Email And Enter The Verification Code</h2>
<body>
<form action="verify_code.php" method="POST">
    <label for="code">Verification Code:</label>
    <input type="text" name="code" required>
    <button type="submit">Verify</button>
</form>
    <?php 
        if (isset($_SESSION["verify_error"])) {
            echo "<p style='color:red'>" . $_SESSION['verify_error'] . "</p>";
            unset($_SESSION['verify_error']); 
        }
    ?>
</body>
</html>
