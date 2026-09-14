<?php

session_start();

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

if (
    !isset($_SESSION["role"]) ||
    strtolower(trim($_SESSION["role"])) !== "admin"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

$courses = isset($_SESSION["courses"])
    ? $_SESSION["courses"]
    : array();

$message = isset($_SESSION["courseMessage"])
    ? $_SESSION["courseMessage"]
    : "";

$error = isset($_SESSION["courseError"])
    ? $_SESSION["courseError"]
    : "";

unset($_SESSION["courseMessage"]);
unset($_SESSION["courseError"]);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Course Management</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

<h2>Course Management</h2>

<?php

if ($message != "") {
    echo "<p>" . htmlspecialchars($message) . "</p>";
}

if ($error != "") {
    echo "<p>" . htmlspecialchars($error) . "</p>";
}

?>

<h3>Add Course</h3>

<form
    method="post"
    action="/cms/controller/CourseController.php?action=addCourse"
>

    <label>Course Code:</label>

    <input
        type="text"
        name="course_code"
        id="course_code"
        required
    >

    <br><br>

    <label>Course Name:</label>

    <input
        type="text"
        name="course_name"
        id="course_name"
        required
    >

    <br><br>

    <label>Teacher ID:</label>

    <input
        type="text"
        name="teacher_id"
        id="teacher_id"
        required
    >

    <br><br>

    <input
        type="submit"
        value="Add Course"
    >

</form>

<hr>

<h3>All Courses</h3>

<table border="1">

    <tr>

        <th>ID</th>

        <th>Course Code</th>

        <th>Course Name</th>

        <th>Teacher ID</th>

        <th>Action</th>

    </tr>

    <?php foreach ($courses as $course) { ?>

    <tr>

        <td>
            <?php
            echo htmlspecialchars($course["id"]);
            ?>
        </td>

        <td>
            <?php
            echo htmlspecialchars($course["course_code"]);
            ?>
        </td>

        <td>
            <?php
            echo htmlspecialchars($course["course_name"]);
            ?>
        </td>

        <td>
            <?php
            echo htmlspecialchars($course["teacher_id"]);
            ?>
        </td>

        <td>

            <form
                method="post"
                action="/cms/controller/CourseController.php?action=deleteCourse"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?php
                    echo htmlspecialchars($course["id"]);
                    ?>"
                >

                <input
                    type="submit"
                    value="Delete"
                >

            </form>

        </td>

    </tr>

    <?php } ?>

</table>

<br>

<a href="/cms/controller/UserController.php?action=users">
    User Management
</a>

<br><br>

<a href="/cms/controller/CourseDropController.php?action=courseDrops">
    Course Drop Approval
</a>

<br><br>

<a href="/cms/view/common/view-profile.php">
    View Profile
</a>

<br><br>

<a href="/cms/view/common/edit-profile.php">
    Edit Profile
</a>

<br><br>

<a href="/cms/view/admin/dashboard.php">
    Back to Admin Dashboard
</a>

<br><br>

<a href="/cms/view/common/logout.php">
    Logout
</a>

</body>

</html>