<?php

session_start();

session_unset();

session_destroy();

setcookie(
    "userEmail",
    "",
    time() - 3600,
    "/"
);

header("Location: /common/login.php");

exit();

?>