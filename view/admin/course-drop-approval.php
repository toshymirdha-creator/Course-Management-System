<?php
session_start();

$requests = isset($_SESSION["courseDrops"]) ? $_SESSION["courseDrops"] : array();

$message = isset($_SESSION["dropMessage"]) ? $_SESSION["dropMessage"] : "";
$error = isset($_SESSION["dropError"]) ? $_SESSION["dropError"] : "";

unset($_SESSION["dropMessage"]);
unset($_SESSION["dropError"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Drop Approval</title>
    <link rel="stylesheet" href="/cms/style.css">
</head>

<body>

<h2>Course Drop Final Approval</h2>

<?php
if ($message != "") {
    echo "<p>" . $message . "</p>";
}

if ($error != "") {
    echo "<p>" . $error . "</p>";
}
?>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Student ID</th>
        <th>Course ID</th>
        <th>Teacher Status</th>
        <th>Admin Status</th>
        <th>Request Date</th>
        <th>Action</th>
    </tr>

    <?php
    foreach ($requests as $request) {
    ?>

    <tr>
        <td><?php echo $request["id"]; ?></td>

        <td><?php echo $request["student_id"]; ?></td>

        <td><?php echo $request["course_id"]; ?></td>

        <td><?php echo $request["teacher_status"]; ?></td>

        <td><?php echo $request["admin_status"]; ?></td>

        <td><?php echo $request["request_date"]; ?></td>

        <td>

            <?php
            if ($request["teacher_status"] == "Approved" &&
                $request["admin_status"] == "Pending") {
            ?>

                <form method="post"
      action="CourseDropController.php?action=approveCourseDrop">

                    <input type="hidden"
                           name="id"
                           value="<?php echo $request["id"]; ?>">

                    <input type="submit" value="Approve">

                </form>

                <br>

                <form method="post"
      action="CourseDropController.php?action=rejectCourseDrop">

                    <input type="hidden"
                           name="id"
                           value="<?php echo $request["id"]; ?>">

                    <input type="submit" value="Reject">

                </form>

            <?php
            } else {
                echo "No Action";
            }
            ?>

        </td>
    </tr>

    <?php
    }
    ?>

</table>

<br>

<a href="UserController.php?action=users">
    User Management
</a>

<br><br>

<a href="CourseController.php?action=courses">
    Course Management
</a>

<br><br>

<a href="ViewProfileController.php">
    View Profile
</a>

<br><br>

<a href="EditProfileController.php?action=editProfile">
    Edit Profile
</a>

</body>
</html>
