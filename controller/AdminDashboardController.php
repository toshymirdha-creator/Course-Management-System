<?php

session_start();

if (
    !isset($_SESSION["isLoggedIn"])
    || $_SESSION["isLoggedIn"] !== true
    || !isset($_SESSION["role"])
    || $_SESSION["role"] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

header("Location: dashboard.php");
exit();

?>