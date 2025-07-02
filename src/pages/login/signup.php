<?php 
require_once "../../../includes/config_session.inc.php";
require_once "../../../includes/signup_view.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Sign Up | Linux-Lab</title>
    <link rel="icon" type="image/x-icon" href="/src/pages/assets/SVGs/favicon.ico">
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../landing_page/landing_page.html">Linux-Lab</a></h2>
            </div>
            <div class="auth__card__content">
                <form id="signup__form" action="../../../includes/signup.inc.php" method="post" >
                    <label for="username-signup">Username:</label>
                    <input required type="text" id="username-signup" class="input--single" name="username" placeholder="Username">
                    <label for="email-signup">Email:</label>
                    <input required type="text" id="email-signup" class="input--single" name="email" placeholder="E-Mail">
                    <label for="pwd-signup">Password:</label>
                    <input required type="password" id="pwd-signup" class="input--single" name="pwd" placeholder="Password">
                    <button class="styled-button">Signup</button>
                </form>
                <a href="./login.php" class="login--guest">Login instead</a>
            </div>
            <?php 
                check_signup_errors();
            ?>
            </div>
        </div>
    </div>
    <script src="./login.js" defer></script>

</body>