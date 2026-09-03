<?php

require_once __DIR__ . '/../../model/dbConnect.php';

function resetEmailExists($email)
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

function updatePassword($email, $newPassword)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $email);
    $newPassword = mysqli_real_escape_string($conn, $newPassword);

    $sql = "UPDATE users
            SET password = '$newPassword'
            WHERE email = '$email'";

    return mysqli_query($conn, $sql);
}

?>