<?php
    require_once "config_session.inc.php";
    require_once "reset_password_view.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../src/pages/login/login.css"/>
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../landing_page/landing_page.html">Linux-Lab</a></h2>
            </div>
            <div class="auth__card__content auth__card__content--reset">
                <h3>Reset Password</h3>
                <form class="form" action="reset_password.inc.php" method="POST" >
                    <label for="email">E-mail</label>
                    <input class="input--single" type="text" id="email" name="email" placeholder="E-Mail">
                    <button class="styled-button">Send Email</button>
                </form>
                <div class="auth__card__content--reset__links">
                    <a class="login--guest" href="../src/pages/login/login.php">Login instead</a>
                    <a class="login--guest" href="../src/pages/login/signup.php">Signup instead</a>
                </div>
                <?php
                    check_reset_password_errors();
                    ?>
            </div>
        </div>
    </div>
</body>
</html>
