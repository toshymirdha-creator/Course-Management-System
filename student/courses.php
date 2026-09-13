<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../common/login.php");
    exit();
}

require_once __DIR__ . "/../controller/CourseController.php";
require_once __DIR__ . "/../controller/EnrollmentController.php";
$courseController = new CourseController();

$courses = $courseController->showCourses();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Available Courses</title>
</head>

<body>

    <h1>Available Courses</h1>

    <?php

    if (mysqli_num_rows($courses) > 0) {

        while ($course = mysqli_fetch_assoc($courses)) {

            echo "<p>";
            echo "Course ID: " . $course["id"] . "<br>";
            echo "Course Code: " . $course["course_code"] . "<br>";
            echo "Course Name: " . $course["course_name"];
            echo "<br>";

echo "<form method='POST' action='enroll.php'>";
echo "<input type='hidden' name='course_id' value='" . $course["id"] . "'>";
echo "<button type='submit'>Enroll</button>";
echo "</form>";
            echo "</p>";

            echo "<hr>";
        }

    } else {

        echo "<p>No courses available.</p>";

    }

    ?>

    <br>

    <a href="dashboard.php">Back to Dashboard</a>

</body>

</html>