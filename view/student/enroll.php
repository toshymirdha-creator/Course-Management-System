<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../common/login.php");
    exit();
}

require_once __DIR__ . "/../controller/EnrollmentController.php";

$student_id = $_SESSION["user"]["id"];
$course_id = $_POST["course_id"];

$enrollmentController = new EnrollmentController();

$result = $enrollmentController->enroll($student_id, $course_id);

if ($result == "success") {
    echo "Course enrolled successfully!";
} elseif ($result == "duplicate") {
    echo "You are already enrolled in this course!";
} else {
    echo "Enrollment failed!";
}

?>

<br><br>

<a href="courses.php">Back to Courses</a>