<?php

session_start();

require_once __DIR__ . '/../model/drop.php';


if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Teacher"
) {

    header("Location: /common/login.php");

    exit();
}


$teacherId = $_SESSION['id'];


$requests =
    getTeacherDropRequests(
        $teacherId
    );


$message = "";

if (isset($_SESSION['dropMessage'])) {

    $message =
        $_SESSION['dropMessage'];

    unset($_SESSION['dropMessage']);
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

    <title>Course Drop Request Approval</title>

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

<h1>Course Drop Request Approval</h1>

</section>


<?php

if ($message != "") {

    echo "<p>";
    echo htmlspecialchars($message);
    echo "</p>";
}

?>


<section class="material_table">

<table>

<thead>

<tr>

<th>SI</th>

<th>Student ID</th>

<th>Student Name</th>

<th>Course</th>

<th>Reason</th>

<th>Request Date</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>


<tbody>

<?php

if (empty($requests)) {

    echo "<tr>";

    echo "<td colspan='8'>";
    echo "No pending course drop requests";
    echo "</td>";

    echo "</tr>";

}
else {

    $si = 1;


    foreach ($requests as $request) {

        echo "<tr>";

        echo "<td>";
        echo $si;
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $request['student_id']
        );
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $request['student_name']
        );
        echo "</td>";


        echo "<td>";

        echo htmlspecialchars(
            $request['course_code']
        );

        echo " - ";

        echo htmlspecialchars(
            $request['course_name']
        );

        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $request['reason']
        );
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $request['request_date']
        );
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $request['teacher_status']
        );
        echo "</td>";


        echo "<td>";

        echo "<form
                method='post'
                action='../controller/dropController.php'
                style='display:inline;'
            >";

        echo "<button
                type='submit'
                name='approve'
                value='"
            . htmlspecialchars(
                $request['id']
            )
            . "'>
                Approve
              </button>";

        echo "</form>";


        echo " ";


        echo "<form
                method='post'
                action='../controller/dropController.php'
                style='display:inline;'
            >";

        echo "<button
                type='submit'
                name='reject'
                value='"
            . htmlspecialchars(
                $request['id']
            )
            . "'>
                Reject
              </button>";

        echo "</form>";

        echo "</td>";


        echo "</tr>";

        $si++;
    }
}

?>

</tbody>

</table>

</section>


<br>

<center>

<a href="teacherDashboard.php">
    Back to Dashboard
</a>

</center>


<script src="/cms/js/form-validation.js"></script>

</body>

</html>