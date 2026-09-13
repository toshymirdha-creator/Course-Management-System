<?php

require_once "../model/dbConnect.php";

function getAllCourseDrops()
{
    global $conn;

    $requests = array();

    $sql = "SELECT * FROM course_drop_requests";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }
    }

    return $requests;
}

function approveCourseDropById($id)
{
    global $conn;

    $id = (int)$id;

    $sql = "UPDATE course_drop_requests
            SET admin_status = 'Approved'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}

function rejectCourseDropById($id)
{
    global $conn;

    $id = (int)$id;

    $sql = "UPDATE course_drop_requests
            SET admin_status = 'Rejected'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}

?>
