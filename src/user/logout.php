<?php
session_start();
session_unset();
session_destroy();
header("Location: ../pages/landing_page/landing_page.html");
exit();
