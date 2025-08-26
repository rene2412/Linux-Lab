<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="../src/pages/login/login.css">
</head>
<body>
    <div class="auth__container">
        <div class="auth__card animation--popup">
            <div class="auth__top">
                <h2 class="auth__top__logo"><a href="../landing_page/landing_page.html">Linux-Lab</a></h2>
            </div>
            <div class="auth__card__content auth__form">
                <form class="" style="width:100%" action="verify_code.php" method="POST">
                    <label for="code">Verification Code:</label>
                    <input class="input--single" placeholder="00000" type="text" id="code" name="code" required>
                    <button class="styled-button" type="submit">Verify</button>
                </form>
            </div>
            <div>
                <a href="../src/pages/lesson_page/landing_page.html" class="login--guest">Guest</a>
                |
                <a href="../src/pages/login/login.php" class="login--guest">Login</a>
            </div>
            </div>
        </div>
    </div>
    <?php 
        if (isset($_SESSION["verify_error"])) {
            echo "<p style='color:red'>" . $_SESSION['verify_error'] . "</p>";
            unset($_SESSION['verify_error']); 
        }
    ?>
</body>
</html>
