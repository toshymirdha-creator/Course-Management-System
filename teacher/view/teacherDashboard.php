<?php

session_start();

if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Teacher"
) {

    header("Location: /common/login.php");
    exit();
}

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

    <link
        rel="stylesheet"
        href="/cms/style.css"
    >

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

        <?php

        echo isset($_SESSION['name'])
            ? htmlspecialchars($_SESSION['name'])
            : "Teacher";

        ?>

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


<br>


<center>

    <a href="/common/logout.php">

        Logout

    </a>

</center>


<script src="/cms/js/form-validation.js"></script>

</body>

</html>