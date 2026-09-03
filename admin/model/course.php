<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getAllCourses()
{
    global $conn;

    $sql = "SELECT id, course_code, course_name, teacher_id
            FROM courses";

    $result = mysqli_query($conn, $sql);

    $courses = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
    }

    return $courses;
}


function addCourseData($code, $name, $teacher)
{
    global $conn;

    $sql = "INSERT INTO courses (course_code, course_name, teacher_id)
            VALUES ('$code', '$name', '$teacher')";

    return mysqli_query($conn, $sql);
}


function deleteCourseById($id)
{
    global $conn;

    $sql = "DELETE FROM courses WHERE id = $id";

    return mysqli_query($conn, $sql);
}

?>