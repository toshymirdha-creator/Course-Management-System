<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getAllCourseDrops()
{
    global $conn;

    $sql = "SELECT * FROM course_drop_requests";

    $result = mysqli_query($conn, $sql);

    $requests = array();

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

    $sql = "UPDATE course_drop_requests
            SET admin_status = 'Approved'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}


function rejectCourseDropById($id)
{
    global $conn;

    $sql = "UPDATE course_drop_requests
            SET admin_status = 'Rejected'
            WHERE id = $id";

    return mysqli_query($conn, $sql);
}

?>