<?php

session_start();


// Check login
if (
    !isset($_SESSION['isLoggedIn']) ||
    $_SESSION['isLoggedIn'] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


// Check admin role
if (
    !isset($_SESSION['role']) ||
    strtolower(trim($_SESSION['role'])) !== "admin"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


$name = isset($_SESSION['name'])
    ? $_SESSION['name']
    : "Admin";

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Admin Dashboard</h1>


    <h2>
        Welcome,
        <?php echo htmlspecialchars($name); ?>!
    </h2>


    <hr>


    <h3>Admin Features</h3>


    <ul>

        <li>
            <a href="/cms/controller/UserController.php?action=users">
                User Management
            </a>
        </li>


        <li>
            <a href="/cms/controller/CourseController.php?action=courses">
                Course Management
            </a>
        </li>


        <li>
            <a href="/cms/controller/CourseDropController.php?action=courseDrops">
                Course Drop Final Approval
            </a>
        </li>


        <li>
            <a href="/cms/view/common/view-profile.php">
                View Profile
            </a>
        </li>


        <li>
            <a href="/cms/view/common/edit-profile.php">
                Edit Profile
            </a>
        </li>

    </ul>


    <hr>


    <br>


    <a href="/cms/view/common/logout.php">
        Logout
    </a>

</body>

</html>