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
        <form action="reset_password_submit.inc.php" method="POST">
            <input type="hidden" name="selector" value="<?php echo $selector ?>">
            <input type="hidden" name="validator" value="<?php echo $validator ?>">
            <input type ="password" name="pwd" placeholder="Enter a new password..">
            <input type ="password" name="rpwd" placeholder="Re-enter your new password..">
            <button type ="submit" name = "reset-password-submit">Reset Password</button>
        </form>
        <?php
        //check for reset password errors;
        if (!empty($_SESSION['rwpd'])) {
            echo '<p style="color:red;">' . $_SESSION['rpwdErrors'] . '</p>';
            unset($_SESSION['rpwdErrors']); 
        }
    }
}