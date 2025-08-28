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
                <h2 class="auth__top__logo"><a href="../../../">Linux-Lab</a></h2>
            </div>
            <div class="auth__form auth__form--login  ">
                <form id="login__form" action="../../../includes/login.inc.php" method="post" class="">
                    <label for="username" class="input__label">Username:</label>
                    <input required class="input--single" type="text" id="username" name="username" placeholder="Username">
                    <label for="pwd" class="input__label">Password:</label>
                    <input required type="password" class="input--single" name="pwd" id="pwd" placeholder="Password">
                    <a class="auth__forgot" href="../../../includes/reset_info.inc.php" >
                        Forgot Password?
                    </a>
                    <button class="styled-button login__button">Login</button>
                </form>
                <?php 
                check_login_errors();
                ?>
            </div>
            <p class="separator">Or</p>
            <?php 
            //    session_start();
               $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
               $dotenv->load();
               
               $client = new Google\Client;
               $client->setClientId($_ENV["CLIENT_ID"]);
               $client->setClientSecret($_ENV["CLIENT_SECRET"]);
               $client->setRedirectUri("https://linux-lab.live/src/pages/login/google.php");

                $client->addScope("email");
                $client->addScope("profile");

                $auth_url = $client->createAuthUrl();            
		?>
            <a class="google__anchor" href="<?= htmlspecialchars($auth_url) ?>">
            <button class="google__button"> <img class="google__image" alt="Google Logo" src="../assets/SVGs/google.png" /> Sign In With Google</button></a>
            <div>
                <a href="../lesson_page/lesson.html" class="login--guest">Guest</a>
                |
                <a href="./signup.php" class="login--guest">Signup </a>
            </div>
        </div>
    </div>

    <script src="./login.js" defer></script>
</html>
