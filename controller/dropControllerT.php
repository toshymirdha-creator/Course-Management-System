<?php

session_start();

require_once __DIR__ . "/../model/dbConnect.php";


/*
|--------------------------------------------------------------------------
| Teacher Login Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


if (
    !isset($_SESSION["role"]) ||
    strtolower(trim($_SESSION["role"])) !== "teacher"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


$teacher_id = (int)$_SESSION["userId"];


/*
|--------------------------------------------------------------------------
| Load Drop Requests
|--------------------------------------------------------------------------
*/

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "requests"
) {

    $sql = "
        SELECT
            cdr.id,
            cdr.student_id,
            cdr.course_id,
            cdr.reason,
            cdr.teacher_status,
            cdr.admin_status,
            cdr.request_date,

            u.name AS student_name,

            c.course_code,
            c.course_name

        FROM course_drop_requests cdr

        INNER JOIN users u
            ON cdr.student_id = u.id

        INNER JOIN courses c
            ON cdr.course_id = c.id

        WHERE c.teacher_id = $teacher_id

        ORDER BY cdr.id DESC
    ";


    $result =
        mysqli_query($conn, $sql);


    $dropRequests = array();


    if ($result) {

        while (
            $row = mysqli_fetch_assoc($result)
        ) {

            $dropRequests[] = $row;

        }

    }


    $_SESSION["dropRequests"] =
        $dropRequests;


    header(
        "Location: /cms/view/teacher/dropApprovalT.php"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Approve Drop Request
|--------------------------------------------------------------------------
*/

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "approve"
) {

    $id = isset($_POST["id"])
        ? (int)$_POST["id"]
        : 0;


    if ($id > 0) {

        $sql = "
            UPDATE course_drop_requests cdr

            INNER JOIN courses c
                ON cdr.course_id = c.id

            SET cdr.teacher_status = 'Approved'

            WHERE cdr.id = $id

            AND c.teacher_id = $teacher_id

            AND cdr.teacher_status = 'Pending'
        ";


        if (mysqli_query($conn, $sql)) {

            $_SESSION["dropMessage"] =
                "Drop request approved.";

        } else {

            $_SESSION["dropError"] =
                "Failed to approve drop request.";
        }

    } else {

        $_SESSION["dropError"] =
            "Invalid request.";
    }


    header(
        "Location: /cms/controller/dropControllerT.php?action=requests"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Reject Drop Request
|--------------------------------------------------------------------------
*/

if (
    isset($_GET["action"]) &&
    $_GET["action"] === "reject"
) {

    $id = isset($_POST["id"])
        ? (int)$_POST["id"]
        : 0;


    if ($id > 0) {

        $sql = "
            UPDATE course_drop_requests cdr

            INNER JOIN courses c
                ON cdr.course_id = c.id

            SET cdr.teacher_status = 'Rejected'

            WHERE cdr.id = $id

            AND c.teacher_id = $teacher_id

            AND cdr.teacher_status = 'Pending'
        ";


        if (mysqli_query($conn, $sql)) {

            $_SESSION["dropMessage"] =
                "Drop request rejected.";

        } else {

            $_SESSION["dropError"] =
                "Failed to reject drop request.";
        }

    } else {

        $_SESSION["dropError"] =
            "Invalid request.";
    }


    header(
        "Location: /cms/controller/dropControllerT.php?action=requests"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Default
|--------------------------------------------------------------------------
*/

header(
    "Location: /cms/controller/dropControllerT.php?action=requests"
);

exit();

?>