
<?php

session_start();

require_once '../../controller/AdminController.php';

if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

$codeErrMsg = "";
$nameErrMsg = "";
$teacherErrMsg = "";
$globalErrMsg = "";

$code = "";
$name = "";
$teacher = "";

$admin = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $code = isset($_POST['code'])
        ? trim($_POST['code'])
        : "";

    $name = isset($_POST['name'])
        ? trim($_POST['name'])
        : "";

    $teacher = isset($_POST['teacher'])
        ? trim($_POST['teacher'])
        : "";

    $flag = true;

    if (empty($code)) {
        $flag = false;
        $codeErrMsg = "Please fill up the course code properly";
    }

    if (empty($name)) {
        $flag = false;
        $nameErrMsg = "Please fill up the course name properly";
    }

    if (empty($teacher)) {
        $flag = false;
        $teacherErrMsg = "Please fill up the teacher ID properly";
    }

    if ($flag) {

        $result = $admin->addCourse($code, $name, $teacher);

        if ($result) {
            $globalErrMsg = "Course added successfully";

            $code = "";
            $name = "";
            $teacher = "";
        }
        else {
            $globalErrMsg = "Course add failed";
        }
    }
}

$courses = $admin->courses();

?>

<!DOCTYPE html>

<html>

<head>

    <title>Course Management</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Course Management</h1>

    <hr>

    <?php

    if ($globalErrMsg != "") {
        echo "<p>" . htmlspecialchars($globalErrMsg) . "</p>";
    }

    ?>

    <form
        method="post"
        action="course-management.php"
        onsubmit="return validateCourseForm(this)"
        novalidate
    >

        <label for="code">
            Course Code:
        </label>

        <input
            type="text"
            name="code"
            id="code"
            value="<?php echo htmlspecialchars($code); ?>"
        >

        <br>

        <p>
            <?php echo htmlspecialchars($codeErrMsg); ?>
        </p>


        <label for="name">
            Course Name:
        </label>

        <input
            type="text"
            name="name"
            id="name"
            value="<?php echo htmlspecialchars($name); ?>"
        >

        <br>

        <p>
            <?php echo htmlspecialchars($nameErrMsg); ?>
        </p>


        <label for="teacher">
            Teacher ID:
        </label>

        <input
            type="number"
            name="teacher"
            id="teacher"
            value="<?php echo htmlspecialchars($teacher); ?>"
        >

        <br>

        <p>
            <?php echo htmlspecialchars($teacherErrMsg); ?>
        </p>


        <input
            type="submit"
            name="addCourse"
            value="Add Course"
        >

    </form>

    <br>

    <h3>Courses</h3>

    <table border="1" cellpadding="10">

        <tr>

            <th>ID</th>

            <th>Course Code</th>

            <th>Course Name</th>

            <th>Teacher ID</th>

        </tr>

        <?php

        foreach ($courses as $course) {

            echo "<tr>";

            echo "<td>"
                . htmlspecialchars($course['id'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($course['course_code'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($course['course_name'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($course['teacher_id'])
                . "</td>";

            echo "</tr>";
        }

        ?>

    </table>

    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

    <script src="/cms/js/form-validation.js"></script>

</body>

</html>

