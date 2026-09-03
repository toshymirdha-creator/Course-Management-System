
<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function loginStudent($email, $password)
{
    global $conn;

    $sql = "SELECT id, name, email, password, role
            FROM users
            WHERE email = '$email'
            AND password = '$password'
            AND role = 'Student'";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $student = mysqli_fetch_assoc($result);

        if ($student) {
            return $student;
        }
    }

    return null;
}


function getStudentProfile($id)
{
    global $conn;

    $sql = "SELECT id, name, email, role
            FROM users
            WHERE id = $id
            AND role = 'Student'";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        $student = mysqli_fetch_assoc($result);

        if ($student) {
            return $student;
        }
    }

    return array();
}

?>

