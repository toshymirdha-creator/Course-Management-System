
<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function submitDropRequest($studentId, $courseId, $reason)
{
    global $conn;

    $checkSql = "SELECT id
                 FROM courses
                 WHERE id = $courseId";

    $checkResult = mysqli_query($conn, $checkSql);

    if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
        return false;
    }


    $sql = "INSERT INTO course_drop_requests
            (student_id, course_id, reason, teacher_status, admin_status, request_date)
            VALUES
            ($studentId, $courseId, '$reason', 'Pending', 'Pending', CURDATE())";

    return mysqli_query($conn, $sql);
}


function getStudentDropRequests($studentId)
{
    global $conn;

    $sql = "SELECT cdr.id,
                   cdr.student_id,
                   cdr.course_id,
                   c.course_name AS course,
                   cdr.reason,
                   cdr.teacher_status AS teacher_approval,
                   cdr.admin_status AS status,
                   cdr.request_date
            FROM course_drop_requests cdr
            JOIN courses c
            ON cdr.course_id = c.id
            WHERE cdr.student_id = $studentId";

    $result = mysqli_query($conn, $sql);

    $requests = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }
    }

    return $requests;
}

?>

