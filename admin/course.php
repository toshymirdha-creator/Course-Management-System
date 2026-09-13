<?php

require_once "../model/dbConnect.php";

function getAllCourses()
{
    global $conn;

    $courses = array();

    $sql = "SELECT * FROM courses";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
    }

    return $courses;
}

function addCourseData($code, $name, $credit, $teacher)
{
    global $conn;

    $code = mysqli_real_escape_string($conn, $code);
    $name = mysqli_real_escape_string($conn, $name);
    $credit = mysqli_real_escape_string($conn, $credit);
    $teacher = (int)$teacher;

    $sql = "INSERT INTO courses (code, name, credit, teacher_id)
            VALUES ('$code', '$name', '$credit', $teacher)";

    return mysqli_query($conn, $sql);
}

function deleteCourseById($id)
{
    global $conn;

    $id = (int)$id;

    $sql = "DELETE FROM courses
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}

?>
