<?php

session_start();

require_once "courseDrop.php";

if (
    !isset($_SESSION["isLoggedIn"])
    || $_SESSION["isLoggedIn"] !== true
    || !isset($_SESSION["role"])
    || $_SESSION["role"] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action === "courseDrops") {
    $_SESSION["courseDrops"] = getAllCourseDrops();
    header("Location: course-drop-approval.php");
    exit();
}

if ($action === "approveCourseDrop") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

        if ($id > 0 && approveCourseDropById($id)) {
            $_SESSION["dropMessage"] = "Course drop request approved.";
        } else {
            $_SESSION["dropError"] = "Failed to approve request.";
        }
    }

    header("Location: CourseDropController.php?action=courseDrops");
    exit();
}

if ($action === "rejectCourseDrop") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

        if ($id > 0 && rejectCourseDropById($id)) {
            $_SESSION["dropMessage"] = "Course drop request rejected.";
        } else {
            $_SESSION["dropError"] = "Failed to reject request.";
        }
    }

    header("Location: CourseDropController.php?action=courseDrops");
    exit();
}

?>