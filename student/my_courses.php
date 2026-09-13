<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../common/login.php");
    exit();
}

require_once __DIR__ . "/../controller/EnrollmentController.php";

$student_id = $_SESSION["user"]["id"];

$enrollmentController = new EnrollmentController();

$myCourses = $enrollmentController->myCourses($student_id);

?>

<!DOCTYPE html>
<html>

<head>
    <title>My Courses</title>
</head>

<body>

    <h1>My Enrolled Courses</h1>

    <?php

    if (mysqli_num_rows($myCourses) > 0) {

        while ($course = mysqli_fetch_assoc($myCourses)) {

            echo "<p>";
            echo "Course Code: " . $course["course_code"] . "<br>";
            echo "Course Name: " . $course["course_name"];
            echo "<br>";

echo "<form method='POST' action='unenroll.php'>";
echo "<input type='hidden' name='course_id' value='" . $course["course_id"] . "'>";
echo "<button type='submit'>Unenroll</button>";
echo "</form>";
            echo "</p>";

            echo "<hr>";
        }

    } else {

        echo "<p>You have not enrolled in any course yet.</p>";

    }

    ?>

    <br>

    <a href="dashboard.php">Back to Dashboard</a>

</body>

</html>