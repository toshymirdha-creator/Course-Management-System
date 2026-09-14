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
    : "";

$email = isset($_SESSION['email'])
    ? $_SESSION['email']
    : "";

$role = isset($_SESSION['role'])
    ? $_SESSION['role']
    : "";

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Student Profile</title>

</head>

<body>

    <h1>My Profile</h1>


    <p>
        <strong>Name:</strong>
        <?php echo htmlspecialchars($name); ?>
    </p>


    <p>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($email); ?>
    </p>


    <p>
        <strong>Role:</strong>
        <?php echo htmlspecialchars($role); ?>
    </p>


    <br>


    <a href="dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>