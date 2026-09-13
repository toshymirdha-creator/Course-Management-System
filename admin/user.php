
<?php

require_once "../model/dbConnect.php";


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

?>

