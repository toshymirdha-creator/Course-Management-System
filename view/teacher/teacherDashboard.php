<?php

session_start();

if (
    !isset($_SESSION['isLoggedIn']) ||
    $_SESSION['isLoggedIn'] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

if (
    !isset($_SESSION['role']) ||
    strtolower(trim($_SESSION['role'])) !== "teacher"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

$name = isset($_SESSION['name'])
    ? $_SESSION['name']
    : "Teacher";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Teacher Dashboard</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <header>

        <nav>

            <h2>Course Management</h2>

            <h2>[LOGO]</h2>

        </nav>

    </header>

    <section class="page_header">

        <h1>TEACHER DASHBOARD</h1>

        <h3>
            Welcome Back
            <?php echo htmlspecialchars($name); ?>
        </h3>

    </section>

    <section>

        <p class="current_role">
            Current Role : Teacher
        </p>

    </section>

    <section class="T_management">

        <p class="T_C_management">
            <a href="manageMaterial.php">
                Manage Course Material
            </a>
        </p>

        <p class="T_C_management">
            <a href="gradeManagement.php">
                Manage Grade
            </a>
        </p>

        <p class="T_C_management">
            <a href="dropApprovalT.php">
                Manage Drop Request
            </a>
        </p>

    </section>

</body>

</html>