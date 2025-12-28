<?php

function check_reset_password_errors() : void {
    if (isset($_SESSION["errors_reset_password"])) {
        $errors = $_SESSION["errors_reset_password"];
        foreach($errors as $error) {
            echo '<p style="color:red;">' . $error . '</p>';
            break;
        }
        unset($_SESSION["errors_reset_password"]); 
    }
}
