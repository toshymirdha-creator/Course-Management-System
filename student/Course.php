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

class Course
{
    public function getAllCourses()
    {
        global $conn;

        $sql = "SELECT * FROM courses";

        $result = mysqli_query($conn, $sql);

        return $result;
    }
}

?>