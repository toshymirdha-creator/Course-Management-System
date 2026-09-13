<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../../common/view/login.php");
    exit();
}

require_once __DIR__ . "/../controller/EnrollmentController.php";

$student_id = $_SESSION["user"]["id"];
$course_id = $_POST["course_id"];

$enrollmentController = new EnrollmentController();

$result = $enrollmentController->unenroll($student_id, $course_id);

if ($result) {
    echo "Course unenrolled successfully!";
} else {
    echo "Unenrollment failed!";
}

?>

<br><br>

<a href="my_courses.php">Back to My Courses</a>