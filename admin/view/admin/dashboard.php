<?php

session_start();

if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Admin"
) {

    header("Location: /common/login.php");

    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

<link rel="stylesheet" href="/cms/style.css">
</head>

<body>

    <h1>Admin Dashboard</h1>

    <h2>

        Welcome

        <?php

        echo isset($_SESSION['name'])
            ? htmlspecialchars($_SESSION['name'])
            : "Admin";

        ?>

    </h2>

    <hr>

    <h3>Admin Features</h3>

    <ul>

        <li>
            <a href="user-management.php">
                User Management
            </a>
        </li>

        <li>
            <a href="course-management.php">
                Course Management
            </a>
        </li>

        <li>
            <a href="course-drop-approval.php">
                Course Drop Final Approval
            </a>
        </li>

        <li>
            <a href="profile/view-profile.php">
                View Profile
            </a>
        </li>

        <li>
            <a href="profile/edit-profile.php">
                Edit Profile
            </a>
        </li>

    </ul>

    <hr>

    <?php

    if (isset($_COOKIE['userEmail'])) {

        echo "<p>Cookie Email: "
            . htmlspecialchars($_COOKIE['userEmail'])
            . "</p>";
    }

    ?>

    <br>

    <a href="/common/logout.php">
        Logout
    </a>

</body>

</html>