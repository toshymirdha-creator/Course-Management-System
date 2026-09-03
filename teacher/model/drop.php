<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getTeacherDropRequests($teacherId)
{
    global $conn;

    $sql = "SELECT cdr.id,
                   cdr.student_id,
                   u.name AS student_name,
                   c.course_code,
                   c.course_name,
                   cdr.reason,
                   cdr.teacher_status,
                   cdr.admin_status,
                   cdr.request_date
            FROM course_drop_requests cdr
            JOIN users u
            ON cdr.student_id = u.id
            JOIN courses c
            ON cdr.course_id = c.id
            WHERE c.teacher_id = $teacherId
            AND cdr.teacher_status = 'Pending'
            ORDER BY cdr.id DESC";

    $result = mysqli_query($conn, $sql);

    $requests = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $requests[] = $row;
        }
    }

    return $requests;
}


function approveTeacherDrop($id, $teacherId)
{
    global $conn;

    $sql = "UPDATE course_drop_requests cdr
            JOIN courses c
            ON cdr.course_id = c.id
            SET cdr.teacher_status = 'Approved'
            WHERE cdr.id = $id
            AND c.teacher_id = $teacherId";

    return mysqli_query($conn, $sql);
}


function rejectTeacherDrop($id, $teacherId)
{
    global $conn;

    $sql = "UPDATE course_drop_requests cdr
            JOIN courses c
            ON cdr.course_id = c.id
            SET cdr.teacher_status = 'Rejected'
            WHERE cdr.id = $id
            AND c.teacher_id = $teacherId";

    return mysqli_query($conn, $sql);
}

?>