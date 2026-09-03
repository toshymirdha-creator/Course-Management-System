
<?php

session_start();

require_once __DIR__ . '/../controller/StudentController.php';


if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Student"
) {

    header("Location: /common/login.php");

    exit();
}


$student = new StudentController();

$materials = $student->materials();

?>

<!DOCTYPE html>

<html>

<head>

    <title>Course Material</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Course Material</h1>

    <hr>

    <h2>Available Course Materials</h2>


    <?php

    if (empty($materials)) {

        echo "<p>No course materials available.</p>";

    }
    else {

        foreach ($materials as $material) {

            echo "<p>";

            echo htmlspecialchars($material['course']);

            echo "</p>";


            echo "<p>";

            echo "Material: "
                . htmlspecialchars($material['material']);

            echo "</p>";


            if (!empty($material['file_name'])) {

                echo "<a href='/cms/uploads/"
                    . htmlspecialchars($material['file_name'])
                    . "' target='_blank'>";

                echo "View Material";

                echo "</a>";

            }
            else {

                echo "<p>File not available</p>";

            }


            echo "<br><br>";
        }
    }

    ?>


    <a href="dashboard.php">
        Back to Dashboard
    </a>


</body>

</html>

