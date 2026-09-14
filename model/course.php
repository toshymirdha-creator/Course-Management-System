<?php

require_once __DIR__ . "/dbConnect.php";

function getAllCourses()
{
    global $conn;

    $courses = array();

    $sql = "SELECT id, course_code, course_name, teacher_id
            FROM courses";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
    }

    return $courses;
}

function addCourseData($course_code, $course_name, $teacher_id)
{
    global $conn;

    $course_code = mysqli_real_escape_string($conn, $course_code);
    $course_name = mysqli_real_escape_string($conn, $course_name);
    $teacher_id = (int)$teacher_id;

    $sql = "INSERT INTO courses
            (course_code, course_name, teacher_id)
            VALUES
            ('$course_code', '$course_name', $teacher_id)";

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