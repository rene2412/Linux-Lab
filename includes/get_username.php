<?php
require_once "config_session.inc.php";

if (isset($_SESSION["user_username"])) {
    echo $_SESSION["user_username"];
} else {
    echo "Guest"; // Or you can return an error message like "Not logged in"
}
?>
