<?php

session_start();

require_once __DIR__ . '/../model/grade.php';


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


$courses = getTeacherCourses($teacherId);


$selectedCourse = isset($_SESSION['selected_course'])
    ? $_SESSION['selected_course']
    : "";


$students = array();


if ($selectedCourse !== "") {

    $students =
        getStudentsForGrade(
            $selectedCourse
        );
}


$message = "";

if (isset($_SESSION['gradeMessage'])) {

    $message =
        $_SESSION['gradeMessage'];

    unset($_SESSION['gradeMessage']);
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

    <title>Grade Management</title>

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

    <h1>Grade Management</h1>

</section>


<?php

if ($message != "") {

    echo "<p>";
    echo htmlspecialchars($message);
    echo "</p>";
}

?>


<section>

<form
    method="post"
    action="../controller/gradeController.php"
    onsubmit="return validateGradeLoad(this)"
    novalidate
>

<section class="course_section">

<div>

<label for="C_ourse">
    Course:
</label>


<select
    name="course"
    id="C_ourse"
>

<option value="">
    Select Course
</option>


<?php

foreach ($courses as $course) {

    echo "<option value='"
        . htmlspecialchars($course['id'])
        . "'";

    if (
        $selectedCourse
        == $course['id']
    ) {

        echo " selected";
    }

    echo ">";

    echo htmlspecialchars(
        $course['course_code']
    );

    echo " - ";

    echo htmlspecialchars(
        $course['course_name']
    );

    echo "</option>";
}

?>

</select>

</div>


<button
    type="submit"
    name="load_students"
    value="1"
>
    Load Students
</button>

</section>

</form>

</section>


<section class="material_table">

<h2>Students</h2>


<form
    method="post"
    action="../controller/gradeController.php"
    onsubmit="return validateGradeSave()"
    novalidate
>

<input
    type="hidden"
    name="course_id"
    value="<?php echo htmlspecialchars($selectedCourse); ?>"
>


<table>

<thead>

<tr>

<th>SI</th>

<th>Student ID</th>

<th>Student Name</th>

<th>Mid</th>

<th>Final</th>

<th>Total</th>

<th>Grade</th>

</tr>

</thead>


<tbody>

<?php

if (empty($students)) {

    echo "<tr>";
    echo "<td colspan='7'>";
    echo "No students found";
    echo "</td>";
    echo "</tr>";

}
else {

    $si = 1;

    foreach ($students as $student) {

        echo "<tr>";

        echo "<td>";
        echo $si;
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $student['student_id']
        );
        echo "</td>";


        echo "<td>";
        echo htmlspecialchars(
            $student['name']
        );
        echo "</td>";


        echo "<td>";

        echo "<input
                type='number'
                name='mid[]'
                min='0'
                max='50'
                value='"
            . htmlspecialchars(
                $student['mid'] ?? ''
            )
            . "'
                oninput='calculateGrade(this)'
            >";

        echo "</td>";


        echo "<td>";

        echo "<input
                type='number'
                name='final[]'
                min='0'
                max='50'
                value='"
            . htmlspecialchars(
                $student['final'] ?? ''
            )
            . "'
                oninput='calculateGrade(this)'
            >";

        echo "</td>";


        echo "<td>";

        echo "<span class='totalMark'>";

        echo htmlspecialchars(
            $student['marks'] ?? ''
        );

        echo "</span>";

        echo "</td>";


        echo "<td>";

        echo "<span class='letterGrade'>";

        echo htmlspecialchars(
            $student['grade'] ?? ''
        );

        echo "</span>";

        echo "</td>";


        echo "<input
                type='hidden'
                name='student_id[]'
                value='"
            . htmlspecialchars(
                $student['student_id']
            )
            . "'>";


        echo "</tr>";

        $si++;
    }
}

?>

</tbody>

</table>


<br>


<?php

if (!empty($students)) {

?>

<button
    type="submit"
    name="save_grades"
    value="1"
>
    Save Changes
</button>

<?php

}

?>

</form>

</section>


<br>

<center>

<a href="teacherDashboard.php">
    Back to Dashboard
</a>

</center>


<script src="/cms/js/form-validation.js"></script>


<script>

function calculateGrade(input) {

    const row = input.closest("tr");

    const midInput =
        row.querySelector(
            "input[name='mid[]']"
        );

    const finalInput =
        row.querySelector(
            "input[name='final[]']"
        );

    const total =
        row.querySelector(".totalMark");

    const grade =
        row.querySelector(".letterGrade");


    const mid =
        parseInt(midInput.value) || 0;

    const final =
        parseInt(finalInput.value) || 0;


    const marks = mid + final;


    total.innerHTML = marks;


    if (marks >= 80) {

        grade.innerHTML = "A+";

    }
    else if (marks >= 75) {

        grade.innerHTML = "A";

    }
    else if (marks >= 70) {

        grade.innerHTML = "A-";

    }
    else if (marks >= 65) {

        grade.innerHTML = "B+";

    }
    else if (marks >= 60) {

        grade.innerHTML = "B";

    }
    else if (marks >= 55) {

        grade.innerHTML = "B-";

    }
    else if (marks >= 50) {

        grade.innerHTML = "C+";

    }
    else if (marks >= 45) {

        grade.innerHTML = "C";

    }
    else if (marks >= 40) {

        grade.innerHTML = "D";

    }
    else {

        grade.innerHTML = "F";
    }
}

</script>

</body>

</html>