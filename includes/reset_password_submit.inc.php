<?php

if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["rpwd"];
    

    if (empty($password) || empty($passwordRepeat)) {
        $_SESSION['rpwdErrors'] = "Error: Password Cannot Be Empty"; 
        header("Location: create_new_password.inc.php?selector=$selector&validator=$validator"); 
    }

    if ($password !== $passwordRepeat) {
        $_SESSION['rpwdErrors'] = "Error: Passwords Do Not Match!";
        header("Location: create_new_password.inc.php?selector=$selector&validator=$validator"); 
    }


    $currentDate = date("U");
    require_once "database.inc.php";

    // Look for the reset entry in pwdReset table
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$selector, $currentDate]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "You need to re-submit your reset request\n";
        exit();
    }

    // Validate the token
    $tokenBin = hex2bin($validator);
    if (!password_verify($tokenBin, $row["pwdResetToken"])) {
        echo "You need to re-submit your reset request (invalid token)\n";
        exit();
    }

    // Fetch the user with the email from pwdReset
    $tokenEmail = $row["pwdResetEmail"];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tokenEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "There was an error finding the user\n";
        exit();
    }

    // Hash the new password and update the user
    $newPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET pwd = ? WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newPassword, $tokenEmail]);

    //Delete the used token
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = $pdo->prepare($sql); 
    $stmt->execute([$tokenEmail]); 
    echo "Password has been updated successfully!\n";
    header("Location: ../src/pages/login/login.php?");
    exit();

} else {
    header("Location: includes/reset_info.inc.php");
}