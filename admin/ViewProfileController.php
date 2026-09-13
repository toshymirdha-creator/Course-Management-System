<?php

session_start();

require_once "user.php";

if (
    !isset($_SESSION["isLoggedIn"])
    || $_SESSION["isLoggedIn"] !== true
    || !isset($_SESSION["role"])
    || $_SESSION["role"] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

$userId = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

if ($userId > 0) {
    $_SESSION["profile"] = getUserById($userId);
}

header("Location: profile/view-profile.php");
exit();

?>