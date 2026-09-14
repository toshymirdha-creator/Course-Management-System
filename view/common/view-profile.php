
<?php

session_start();

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

$name = isset($_SESSION["name"])
    ? $_SESSION["name"]
    : "";

$email = isset($_SESSION["email"])
    ? $_SESSION["email"]
    : "";

$role = isset($_SESSION["role"])
    ? $_SESSION["role"]
    : "";

?>

<!DOCTYPE html>

<html>

<head>

    <title>View Profile</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

<h2>My Profile</h2>


<p>

    <strong>Name:</strong>

    <?php
    echo htmlspecialchars($name);
    ?>

</p>


<p>

    <strong>Email:</strong>

    <?php
    echo htmlspecialchars($email);
    ?>

</p>


<p>

    <strong>Role:</strong>

    <?php
    echo htmlspecialchars($role);
    ?>

</p>


<br>


<a href="/cms/controller/UserController.php?action=users">
    User Management
</a>


<br><br>


<a href="/cms/controller/CourseController.php?action=courses">
    Course Management
</a>


<br><br>


<a href="/cms/controller/CourseDropController.php?action=courseDrops">
    Course Drop Approval
</a>


<br><br>


<a href="/cms/view/common/edit-profile.php">
    Edit Profile
</a>


<br><br>


<a href="/cms/view/admin/dashboard.php">
    Back to Admin Dashboard
</a>


</body>

</html>
