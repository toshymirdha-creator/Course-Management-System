<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../model/course.php";

class CourseController
{
    public function showCourses()
    {
        return getAllCourses();
    }
}

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action !== "") {
    if (
        !isset($_SESSION["isLoggedIn"]) ||
        $_SESSION["isLoggedIn"] !== true ||
        !isset($_SESSION["role"]) ||
        strtolower(trim($_SESSION["role"])) !== "admin"
    ) {
        header("Location: /cms/view/common/login.php");
        exit();
    }
}

if ($action === "courses") {

    $_SESSION["courses"] = getAllCourses();

    header("Location: /cms/view/admin/course-management.php");
    exit();
}

if ($action === "addCourse") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $course_code = isset($_POST["course_code"])
            ? trim($_POST["course_code"])
            : "";

        $course_name = isset($_POST["course_name"])
            ? trim($_POST["course_name"])
            : "";

        $teacher_id = isset($_POST["teacher_id"])
            ? trim($_POST["teacher_id"])
            : "";

        if (
            $course_code === "" ||
            $course_name === "" ||
            $teacher_id === ""
        ) {

            $_SESSION["courseError"] = "All fields are required.";

        } else {

            if (addCourseData(
                $course_code,
                $course_name,
                $teacher_id
            )) {

                $_SESSION["courseMessage"] =
                    "Course added successfully.";

            } else {

                $_SESSION["courseError"] =
                    "Failed to add course.";
            }
        }
    }

    header(
        "Location: /cms/controller/CourseController.php?action=courses"
    );

    exit();
}

if ($action === "deleteCourse") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $id = isset($_POST["id"])
            ? (int)$_POST["id"]
            : 0;

        if ($id > 0 && deleteCourseById($id)) {

            $_SESSION["courseMessage"] =
                "Course deleted successfully.";

        } else {

            $_SESSION["courseError"] =
                "Failed to delete course.";
        }
    }

    header(
        "Location: /cms/controller/CourseController.php?action=courses"
    );

    exit();
}

?>