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


// Load controller
require_once __DIR__ . "/../../controller/EnrollmentController.php";


// Get logged-in student's ID
$student_id = $_SESSION['userId'];


// Create controller
$enrollmentController = new EnrollmentController();


// Get student's enrolled courses
$myCourses = $enrollmentController->myCourses($student_id);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>My Courses</title>

</head>

<body>

    <h1>My Enrolled Courses</h1>


    <?php if (!empty($myCourses)) { ?>

        <?php foreach ($myCourses as $course) { ?>

            <p>

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


                <form method="POST" action="unenroll.php">

                    <input
                        type="hidden"
                        name="course_id"
                        value="<?php
                        echo htmlspecialchars(
                            isset($course["course_id"])
                                ? $course["course_id"]
                                : $course["id"]
                        );
                        ?>"
                    >

                    <button type="submit">
                        Unenroll
                    </button>

                </form>

            </p>

            <hr>

        <?php } ?>

    <?php } else { ?>

        <p>
            You have not enrolled in any course yet.
        </p>

    <?php } ?>


    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>