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
    <title>Student Profile</title>
</head>

<body>

    <h1>My Profile</h1>

    <p>
        <strong>Name:</strong>
        <?php echo $_SESSION["user"]["name"]; ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?php echo $_SESSION["user"]["email"]; ?>
    </p>

    <p>
        <strong>Role:</strong>
        <?php echo $_SESSION["user"]["role"]; ?>
    </p>

    <br>

    <a href="dashboard.php">Back to Dashboard</a>

</body>

</html>