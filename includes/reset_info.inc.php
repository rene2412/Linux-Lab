<?php
	if (session_status() === PHP_SESSION_NONE) {
    		session_start();
	}
	require_once "reset_password_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Linux-Lab</title>
    <link rel="icon" type="image/x-icon" href="/src/pages/assets/SVGs/favicon.ico">
    <link rel="stylesheet" href="../src/pages/login/login.css"/>
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../">Linux-Lab</a></h2>
            </div>
            <div class="auth__card__content auth__card__content--reset">
                <form class="form" action="reset_password.inc.php" method="POST" >
                    <h2 style="color:white" > Verify your email</h2>
                    <label for="email">E-mail</label>
                    <input class="input--single" type="text" id="email" name="email" placeholder="E-Mail">
                    <button class="styled-button" style="width:100%">Send Email</button>
                </form>
                <?php
                    check_reset_password_errors();
                    ?>
            </div>
                <div class="auth__card__content--reset__links">
                    <div>
                    <!-- <a class="login--guest" href="../src/pages/login/login.php">Login</a>
                    |
                    <a class="login--guest" href="../src/pages/login/signup.php">Signup</a> -->

                    </div>
                </div>
        </div>
    </div>
</body>
</html>
