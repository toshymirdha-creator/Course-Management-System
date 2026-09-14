<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "course_management_system";

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>
