<?php

session_start();

require_once "course.php";

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

if ($action === "courses") {
    $_SESSION["courses"] = getAllCourses();
    header("Location: course-management.php");
    exit();
}

if ($action === "addCourse") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $code = trim($_POST["code"]);
        $name = trim($_POST["name"]);
        $credit = trim($_POST["credit"]);
        $teacher = trim($_POST["teacher"]);

        if ($code === "" || $name === "" || $credit === "" || $teacher === "") {
            $_SESSION["courseError"] = "All fields are required.";
        } else {
            if (addCourseData($code, $name, $credit, $teacher)) {
                $_SESSION["courseMessage"] = "Course added successfully.";
            } else {
                $_SESSION["courseError"] = "Failed to add course.";
            }
        }
    }

    header("Location: CourseController.php?action=courses");
    exit();
}

if ($action === "deleteCourse") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

        if ($id > 0 && deleteCourseById($id)) {
            $_SESSION["courseMessage"] = "Course deleted successfully.";
        } else {
            $_SESSION["courseError"] = "Failed to delete course.";
        }
    }

    header("Location: CourseController.php?action=courses");
    exit();
}

?>