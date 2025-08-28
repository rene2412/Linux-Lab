<?php
session_start();
require_once "config_session.inc.php";

$selector = $_GET["selector"];
$validator = $_GET["validator"];

if (empty($selector) || empty($validator)) {
    echo "Could not validate your request!";
}
else {
    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/pages/login/login.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../">Linux-Lab</a></h2>
            </div>
            <div class="auth__card__content auth__card__content--reset">
                <h3>Create New Password</h3>
                <form action="reset_password_submit.inc.php" method="POST">
                    <input type="hidden" name="selector" value="<?php echo $selector ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator ?>">
                    <label for="pwd" class="input__label">New Password:</label>
                    <input required type="password" class="input--single" name="pwd" id="pwd" placeholder="Enter a new password..">
                    <label for="rpwd" class="input__label">Confirm Password:</label>
                    <input required type="password" class="input--single" name="rpwd" id="rpwd" placeholder="Re-enter your new password..">
                    <button type="submit" name="reset-password-submit" class="styled-button">Reset Password</button>
                </form>
                <?php
                if (!empty($_SESSION['rwpd'])) {
                    echo '<p style="color:red;">' . $_SESSION['rpwdErrors'] . '</p>';
                    unset($_SESSION['rpwdErrors']); 
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    }
}