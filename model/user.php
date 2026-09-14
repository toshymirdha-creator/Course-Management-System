<?php

require_once __DIR__ . '/dbConnect.php';


// Get all users
function getAllUsers()
{
    global $conn;

    $users = array();

    $sql = "SELECT id, name, email, role FROM users";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    return $users;
}


// Add new user
function addUserData($name, $email, $role)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $role = mysqli_real_escape_string($conn, $role);

    $sql = "INSERT INTO users (name, email, role)
            VALUES ('$name', '$email', '$role')";

    return mysqli_query($conn, $sql);
}


// Get user by ID
function getUserById($id)
{
    global $conn;

    $id = (int)$id;

    $sql = "SELECT id, name, email, role
            FROM users
            WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}


// Update user name
function updateUserName($id, $name)
{
    global $conn;

    $id = (int)$id;
    $name = mysqli_real_escape_string($conn, $name);

    $sql = "UPDATE users
            SET name = '$name'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}


// Update user email
function updateUserEmail($id, $email)
{
    global $conn;

    $id = (int)$id;
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "UPDATE users
            SET email = '$email'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}


// Login user
function loginUser($email, $password)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT id, name, email, role
            FROM users
            WHERE email = '$email'
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }

    return false;
}

?>