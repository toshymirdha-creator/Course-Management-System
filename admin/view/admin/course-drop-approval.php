<?php

session_start();

require_once '../../controller/AdminController.php';

$globalMsg = "";

$admin = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $id = isset($_POST['id'])
        ? $_POST['id']
        : 0;

    if (isset($_POST['approve'])) {

        $admin->approveCourseDrop($id);

        $globalMsg = "Course drop request approved successfully";
    }

    if (isset($_POST['reject'])) {

        $admin->rejectCourseDrop($id);

        $globalMsg = "Course drop request rejected";
    }
}

$requests = $admin->courseDrops();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Course Drop Final Approval</title>

<link rel="stylesheet" href="/cms/style.css">
</head>

<body>

    <h1>Course Drop Final Approval</h1>

    <hr>

    <?php

    if ($globalMsg != "") {

        echo "<p>" . htmlspecialchars($globalMsg) . "</p>";
    }

    ?>

    <table border="1" cellpadding="10">

        <tr>

            <th>Student Name</th>
            <th>Student ID</th>
            <th>Course</th>
            <th>Teacher Approval</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        <?php

        foreach ($requests as $request) {

            echo "<tr>";

            echo "<td>"
                . htmlspecialchars($request['student_name'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($request['student_id'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($request['course'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($request['teacher_approval'])
                . "</td>";

            echo "<td>"
                . htmlspecialchars($request['status'])
                . "</td>";

            echo "<td>";

            if ($request['status'] == "Pending") {

                echo "<form method='post' action='course-drop-approval.php'>";

                echo "<input type='hidden' name='id' value='"
                    . htmlspecialchars($request['id'])
                    . "'>";

                echo "<input type='submit' name='approve' value='Approve'>";

                echo "<input type='submit' name='reject' value='Reject'>";

                echo "</form>";
            }
            else {

                echo "No Action";
            }

            echo "</td>";

            echo "</tr>";
        }

        ?>

    </table>

    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>