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
    die("Database connection failed");
}

class User
{
    public function loginUser($email, $password)
    {
        global $conn;

        $sql = "SELECT * FROM users 
                WHERE email = '$email' 
                AND password = '$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
}

?>