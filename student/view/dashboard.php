<?php

session_start();


if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Student"
) {

    header("Location: /common/login.php");

    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Student Dashboard</h1>

    <hr>


    <h2>

        Welcome

        <?php

        if (isset($_SESSION['name'])) {

            echo htmlspecialchars($_SESSION['name']);

        }
        else {

            echo "Student";

        }

        ?>

    </h2>


    <p>

        Student ID:

        <?php

        echo isset($_SESSION['id'])
            ? htmlspecialchars($_SESSION['id'])
            : "N/A";

        ?>

    </p>


    <p>

        Email:

        <?php

        echo isset($_SESSION['email'])
            ? htmlspecialchars($_SESSION['email'])
            : "N/A";

        ?>

    </p>


    <hr>


    <h3>Student Features</h3>


    <a href="course-enrollment.php">

        Course Enrollment

    </a>


    <br><br>


    <a href="course-material.php">

        Course Material

    </a>


    <br><br>


    <a href="course-drop-request.php">

        Course Drop Request

    </a>


    <br><br>


    <a href="/common/logout.php">

        Logout

    </a>

</body>

</html>