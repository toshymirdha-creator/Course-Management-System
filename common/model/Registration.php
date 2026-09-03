<?php

require_once __DIR__ . '/../../model/dbConnect.php';

function registerUser($name, $email, $password, $role)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$password', '$role')";

    return mysqli_query($conn, $sql);
}

function emailExists($email)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT id FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}

?>