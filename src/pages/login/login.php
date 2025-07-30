<?php 
require_once "../../../includes/config_session.inc.php";
require_once "../../../includes/signup_view.inc.php";
require_once "../../../includes/login_view.inc.php";
require_once __DIR__. "/../../../vendor/autoload.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./login.css">
    <title>Login | Linux-Lab</title>
    <link rel="icon" type="image/x-icon" href="../assets/SVGs/favicon.ico">
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../landing_page/landing_page.html">Linux-Lab</a></h2>
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
                    <a href="../lesson_page/lesson.html" class="login--guest">Continue as guest</a>
                    <a href="./signup.php" class="login--guest">Signup instead</a>
                </form>
                <?php 
                check_login_errors();
                ?>
            </div>
            <?php 
               session_start();
               $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
               $dotenv->load();
               
               $client = new Google\Client;
               $client->setClientId($_ENV["CLIENT_ID"]);
               $client->setClientSecret($_ENV["CLIENT_SECRET"]);
               $client->setRedirectUri("http://localhost/Linux-Lab/src/pages/login/google.php");

                $client->addScope("email");
                $client->addScope("profile");

                $auth_url = $client->createAuthUrl();
            
                ?>
            <a href="<?= htmlspecialchars($auth_url) ?>">
            <button>Sign In With Google</button></a>
            <form action="../../../includes/reset_info.inc.php" method="post">
                <button class="styled-button auth__forgot">Reset Password</button>
            </form>
        </div>
    </div>

    <script src="./login.js" defer></script>
</html>