<?php 
require_once "../../../includes/config_session.inc.php";
require_once "../../../includes/signup_view.inc.php";
require_once "../../../includes/login_view.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2>Linux-Lab</h2>
            </div>
            <div class="auth__switch">
            </div>
            <div class="auth__form auth__form--login  ">
                <form id="login__form" action="../../../includes/login.inc.php" method="post" class="">
                    <label for="username" class="input__label">Username:</label>
                    <input required class="input--single" type="text" id="username" name="username" placeholder="Username">
                    <label for="pwd" class="input__label">Password:</label>
                    <input required type="password" class="input--single" name="pwd" id="pwd" placeholder="Password">
                    <button class="styled-button">Login</button>
                    <a href="../lesson_page/lesson.html" class="login--guest">continue as guest</a>
                </form>
                <?php 
                check_login_errors();
                ?>
            </div>
            <form action="includes/reset_info.inc.php" method="post">
                <button class="styled-button auth__forgot">Reset Password</button>
            </form>
        </div>
    </div>

    <script src="./login.js" defer></script>
</html>