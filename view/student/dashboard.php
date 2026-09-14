<?php

session_start();


// Check if user is logged in
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


$name = isset($_SESSION['name'])
    ? $_SESSION['name']
    : "Student";

$email = isset($_SESSION['email'])
    ? $_SESSION['email']
    : "";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Student Dashboard</title>

</head>

<body>

    <h1>Student Dashboard</h1>


    <h2>
        Welcome, <?php echo htmlspecialchars($name); ?>!
    </h2>


    <p>
        You are successfully logged in.
    </p>


    <p>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($email); ?>
    </p>


    <p>
        <strong>Role:</strong>
        Student
    </p>


    <hr>


    <h3>Student Menu</h3>

    <ul>

        <li>
            <a href="/cms/view/student/courses.php">
                View Courses
            </a>
        </li>

        <li>
            <a href="/cms/view/student/my_courses.php">
                My Courses
            </a>
        </li>

        <li>
            <a href="/cms/view/student/profile.php">
                My Profile
            </a>
        </li>

        <li>
            <a href="/cms/view/common/logout.php">
                Logout
            </a>
        </li>

    </ul>

</body>

</html>