
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
$globalErrMsg = "";

$selectedCourse = "";

$student = new StudentController();

$studentId = $_SESSION['id'];


// =========================
// AJAX + JSON + GET
// Course Search
// =========================

if (
    $_SERVER['REQUEST_METHOD'] === "GET"
    && isset($_GET['searchCourse'])
) {

    header("Content-Type: application/json");

    $search = trim($_GET['searchCourse']);

    $courses = $student->courses();

    $result = array();

    foreach ($courses as $courseData) {

        if (
            $search === ""
            || stripos(
                $courseData['course_name'],
                $search
            ) !== false
            || stripos(
                $courseData['course_code'],
                $search
            ) !== false
        ) {

            $result[] = $courseData;
        }
    }

    echo json_encode($result);

    exit();
}


// =========================
// Get all courses normally
// =========================

$courses = $student->courses();


// =========================
// Course Enrollment
// Normal POST
// =========================

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $selectedCourse = isset($_POST['course'])
        ? trim($_POST['course'])
        : "";

    $flag = true;


    if (empty($selectedCourse)) {

        $flag = false;

        $courseErrMsg = "Please select a course";
    }


    if ($flag) {

        $result = $student->enroll(
            $studentId,
            $selectedCourse
        );


        if ($result) {

            $globalErrMsg =
                "Course enrolled successfully";

            $selectedCourse = "";
        }
        else {

            $globalErrMsg =
                "Course enrollment failed";
        }
    }
    else {

        $globalErrMsg =
            "Course enrollment failed";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Course Enrollment</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Course Enrollment</h1>

    <hr>


    <?php

    if ($globalErrMsg != "") {

        echo "<p>"
            . htmlspecialchars($globalErrMsg)
            . "</p>";
    }

    ?>


    <!-- =========================
         COURSE SEARCH
         AJAX + GET + JSON
         ========================= -->

    <h2>Search Course</h2>

    <input
        type="text"
        id="courseSearch"
        placeholder="Search by course name or code"
    >

    <br><br>


    <form
        method="post"
        action="course-enrollment.php"
        onsubmit="return validateCourseEnrollment(this)"
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
                    . htmlspecialchars($courseData['id'])
                    . "'>";

                echo htmlspecialchars(
                    $courseData['course_name']
                );

                echo " ("
                    . htmlspecialchars(
                        $courseData['course_code']
                    )
                    . ")";

                echo "</option>";
            }

            ?>

        </select>


        <br>


        <?php

        echo htmlspecialchars($courseErrMsg);

        ?>


        <br><br>


        <input
            type="submit"
            name="enroll"
            value="Enroll Course"
        >

    </form>


    <br>


    <a href="dashboard.php">
        Back to Dashboard
    </a>


    <script src="/cms/js/form-validation.js"></script>


    <!-- =========================
         AJAX + GET + JSON
         ========================= -->

    <script>

    document
        .getElementById("courseSearch")
        .addEventListener(
            "keyup",
            function() {

                const search =
                    this.value.trim();

                const xhr =
                    new XMLHttpRequest();


                xhr.open(
                    "GET",
                    "course-enrollment.php?searchCourse="
                    + encodeURIComponent(search),
                    true
                );


                xhr.onload = function() {

                    if (xhr.status === 200) {

                        try {

                            const courses =
                                JSON.parse(
                                    xhr.responseText
                                );


                            const courseSelect =
                                document.getElementById(
                                    "course"
                                );


                            courseSelect.innerHTML =
                                "<option value=''>Select Course</option>";


                            courses.forEach(
                                function(course) {

                                    const option =
                                        document.createElement(
                                            "option"
                                        );


                                    option.value =
                                        course.id;


                                    option.textContent =
                                        course.course_name
                                        + " ("
                                        + course.course_code
                                        + ")";


                                    courseSelect.appendChild(
                                        option
                                    );

                                }
                            );

                        }
                        catch (error) {

                            console.log(
                                "JSON response error"
                            );

                        }

                    }

                };


                xhr.send();

            }
        );

    </script>

</body>

</html>
