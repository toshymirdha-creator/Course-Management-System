<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../../common/view/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
</head>

<body>

    <h1>Student Dashboard</h1>

    <p>Welcome, <?php echo $_SESSION["user"]["name"]; ?>!</p>

    <a href="courses.php">
        View Available Courses
    </a>

    <br><br>

    <a href="my_courses.php">
        My Courses
    </a>

    <br><br>

    <a href="profile.php">
        My Profile
    </a>

    <br><br>

    <a href="../../common/controller/LogoutController.php">
        Logout
    </a>

</body>

</html>