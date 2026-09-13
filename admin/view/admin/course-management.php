<?php
session_start();

$courses = isset($_SESSION["courses"]) ? $_SESSION["courses"] : array();

$message = isset($_SESSION["courseMessage"]) ? $_SESSION["courseMessage"] : "";
$error = isset($_SESSION["courseError"]) ? $_SESSION["courseError"] : "";

unset($_SESSION["courseMessage"]);
unset($_SESSION["courseError"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Management</title>
    <link rel="stylesheet" href="../../../style.css">
</head>

<body>

<h2>Course Management</h2>

<?php
if ($message != "") {
    echo "<p>" . $message . "</p>";
}

if ($error != "") {
    echo "<p>" . $error . "</p>";
}
?>

<h3>Add Course</h3>

<form method="post" action="../../controller/AdminController.php?action=addCourse">

    <label>Course Code:</label>
    <input type="text" name="code" id="code">
    <br><br>

    <label>Course Name:</label>
    <input type="text" name="name" id="name">
    <br><br>

    <label>Credit:</label>
    <input type="text" name="credit" id="credit">
    <br><br>

    <label>Teacher ID:</label>
    <input type="text" name="teacher" id="teacher">
    <br><br>

    <input type="submit" value="Add Course">

</form>

<hr>

<h3>All Courses</h3>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Credit</th>
        <th>Teacher ID</th>
        <th>Action</th>
    </tr>

    <?php
    foreach ($courses as $course) {
    ?>

    <tr>
        <td><?php echo $course["id"]; ?></td>
        <td><?php echo $course["code"]; ?></td>
        <td><?php echo $course["name"]; ?></td>
        <td><?php echo $course["credit"]; ?></td>
        <td><?php echo $course["teacher_id"]; ?></td>

        <td>
            <form method="post" action="../../controller/AdminController.php?action=deleteCourse">

                <input type="hidden" name="id" value="<?php echo $course["id"]; ?>">

                <input type="submit" value="Delete">

            </form>
        </td>
    </tr>

    <?php
    }
    ?>

</table>

<br>

<a href="../../controller/AdminController.php?action=users">
    User Management
</a>

<br><br>

<a href="../../controller/AdminController.php?action=courseDrops">
    Course Drop Approval
</a>

<br><br>

<a href="../../controller/AdminController.php?action=profile">
    View Profile
</a>

<br><br>

<a href="../../controller/AdminController.php?action=editProfile">
    Edit Profile
</a>

</body>
</html>