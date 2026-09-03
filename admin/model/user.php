<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getAllUsers()
{
    global $conn;

    $sql = "SELECT id, name, email, role FROM users";

    $result = mysqli_query($conn, $sql);

    $users = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $users[] = $row;
        }
    }

    return $users;
}


function addUserData($name, $email, $role)
{
    global $conn;

    $password = "123456";

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES ('$name', '$email', '$password', '$role')";

    return mysqli_query($conn, $sql);
}


function getUserById($id)
{
    global $conn;

    $sql = "SELECT id, name, email, role
            FROM users
            WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $user = mysqli_fetch_assoc($result);

        if ($user) {

            return $user;
        }
    }

    return array();
}


/* =========================
   UPDATE EMAIL
   ========================= */

function updateUserEmail($id, $email)
{
    global $conn;

    $email = mysqli_real_escape_string(
        $conn,
        $email
    );

    $sql = "UPDATE users
            SET email = '$email'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}

?>
