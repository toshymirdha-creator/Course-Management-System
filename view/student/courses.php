<?php

session_start();


// Check login
if (
    !isset($_SESSION['isLoggedIn']) ||
    $_SESSION['isLoggedIn'] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


// Check student role
if (
    !isset($_SESSION['role']) ||
    strtolower(trim($_SESSION['role'])) !== "student"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


// Load controllers
require_once __DIR__ . "/../../controller/CourseController.php";
require_once __DIR__ . "/../../controller/EnrollmentController.php";


$courseController = new CourseController();

$courses = $courseController->showCourses();

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Available Courses</title>

</head>

<body>

    <h1>Available Courses</h1>


    <?php if (!empty($courses)) { ?>

        <?php foreach ($courses as $course) { ?>

            <p>

                <strong>Course ID:</strong>
                <?php echo htmlspecialchars($course["id"]); ?>

                <br>

                <strong>Course Code:</strong>
                <?php
                echo htmlspecialchars(
                    isset($course["course_code"])
                        ? $course["course_code"]
                        : $course["code"]
                );
                ?>

                <br>

                <strong>Course Name:</strong>
                <?php
                echo htmlspecialchars(
                    isset($course["course_name"])
                        ? $course["course_name"]
                        : $course["name"]
                );
                ?>

                <br><br>

                <form method="POST" action="enroll.php">

                    <input
                        type="hidden"
                        name="course_id"
                        value="<?php echo htmlspecialchars($course["id"]); ?>"
                    >

                    <button type="submit">
                        Enroll
                    </button>

                </form>

            </p>

            <hr>

        <?php } ?>

    <?php } else { ?>

        <p>No courses available.</p>

    <?php } ?>


    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>