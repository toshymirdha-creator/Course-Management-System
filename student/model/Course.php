
<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getAvailableCourses()
{
    global $conn;

    $sql = "SELECT id,
                   course_code,
                   course_name,
                   teacher_id
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


function getMaterials()
{
    global $conn;

    $sql = "SELECT cm.id,
                   c.course_name AS course,
                   cm.title AS material,
                   cm.file_name
            FROM course_materials cm
            JOIN courses c
            ON cm.course_id = c.id";

    $result = mysqli_query($conn, $sql);

    $materials = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $materials[] = $row;
        }
    }

    return $materials;
}


function enrollCourse($studentId, $courseId)
{
    global $conn;

    $checkSql = "SELECT id
                 FROM enrollments
                 WHERE student_id = $studentId
                 AND course_id = $courseId";

    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        return false;
    }


    $sql = "INSERT INTO enrollments (student_id, course_id)
            VALUES ($studentId, $courseId)";

    return mysqli_query($conn, $sql);
}


function getEnrolledCourses($studentId)
{
    global $conn;

    $sql = "SELECT e.id,
                   e.student_id,
                   e.course_id,
                   c.course_code,
                   c.course_name,
                   c.teacher_id
            FROM enrollments e
            JOIN courses c
            ON e.course_id = c.id
            WHERE e.student_id = $studentId";

    $result = mysqli_query($conn, $sql);

    $enrolled = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $enrolled[] = $row;
        }
    }

    return $enrolled;
}

?>

