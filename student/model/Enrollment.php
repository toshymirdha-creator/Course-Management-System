<?php

require_once __DIR__ . "/../../model/dbConnect.php";

class Enrollment
{
    public function enrollStudent($student_id, $course_id)
    {
        global $conn;

    $checkSql = "SELECT * FROM enrollments
                 WHERE student_id = '$student_id'
                 AND course_id = '$course_id'";

    $checkResult = mysqli_query($conn, $checkSql);

   if (mysqli_num_rows($checkResult) > 0) {
    return "duplicate";
}

    $sql = "INSERT INTO enrollments (student_id, course_id)
            VALUES ('$student_id', '$course_id')";

    if (mysqli_query($conn, $sql)) {
    return "success";
} else {
    return "error";
}
    }
    public function getMyCourses($student_id)
{
    global $conn;

   $sql = "SELECT enrollments.id, enrollments.course_id, courses.course_code, courses.course_name
            FROM enrollments
            JOIN courses ON enrollments.course_id = courses.id
            WHERE enrollments.student_id = '$student_id'";

    return mysqli_query($conn, $sql);
}

public function unenrollStudent($student_id, $course_id)
{
    global $conn;

    $sql = "DELETE FROM enrollments
            WHERE student_id = '$student_id'
            AND course_id = '$course_id'";

    return mysqli_query($conn, $sql);
}
}

?>