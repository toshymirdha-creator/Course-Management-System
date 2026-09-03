
<?php

session_start();

require_once __DIR__ . '/../controller/StudentController.php';


if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Student"
) {

    header("Location: /common/login.php");

    exit();
}


$courseErrMsg = "";
$reasonErrMsg = "";
$globalErrMsg = "";

$selectedCourse = "";
$reason = "";

$student = new StudentController();

$studentId = $_SESSION['id'];


// Get student's enrolled courses
$courses = $student->enrolledCourses($studentId);


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $selectedCourse = isset($_POST['course'])
        ? trim($_POST['course'])
        : "";

    $reason = isset($_POST['reason'])
        ? trim($_POST['reason'])
        : "";

    $flag = true;


    if (empty($selectedCourse)) {

        $flag = false;

        $courseErrMsg = "Please select a course";
    }


    if (empty($reason)) {

        $flag = false;

        $reasonErrMsg = "Please enter a reason";
    }


    if ($flag) {

        $result = $student->submitDrop(
            $studentId,
            $selectedCourse,
            $reason
        );


        if ($result) {

            $globalErrMsg =
                "Course drop request submitted successfully";

            $selectedCourse = "";
            $reason = "";
        }
        else {

            $globalErrMsg =
                "Course drop request failed";
        }
    }
    else {

        $globalErrMsg =
            "Course drop request failed";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Course Drop Request</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Course Drop Request</h1>

    <hr>


    <?php

    if ($globalErrMsg != "") {

        echo "<p>"
            . htmlspecialchars($globalErrMsg)
            . "</p>";
    }

    ?>


    <form
        method="post"
        action="course-drop-request.php"
        onsubmit="return validateCourseDropRequest(this)"
        novalidate
    >


        <label for="course">
            Select Course:
        </label>


        <select
            name="course"
            id="course"
        >

            <option value="">
                Select Course
            </option>


            <?php

            foreach ($courses as $courseData) {

                echo "<option value='"
                    . htmlspecialchars($courseData['course_id'])
                    . "'";

                if ($selectedCourse == $courseData['course_id']) {
                    echo " selected";
                }

                echo ">";

                echo htmlspecialchars(
                    $courseData['course_name']
                );

                echo "</option>";
            }

            ?>

        </select>


        <br>

        <?php
        echo htmlspecialchars($courseErrMsg);
        ?>

        <br><br>


        <label for="reason">
            Reason:
        </label>


        <br>


        <textarea
            name="reason"
            id="reason"
            rows="5"
            cols="40"
        ><?php echo htmlspecialchars($reason); ?></textarea>


        <br>


        <?php
        echo htmlspecialchars($reasonErrMsg);
        ?>


        <br><br>


        <input
            type="submit"
            name="dropRequest"
            value="Submit Request"
        >

    </form>


    <br>


    <a href="dashboard.php">
        Back to Dashboard
    </a>


    <script src="/cms/js/form-validation.js"></script>

</body>

</html>

