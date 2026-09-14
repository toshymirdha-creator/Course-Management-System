<?php

session_start();


/*
|--------------------------------------------------------------------------
| Login Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


if (
    !isset($_SESSION["role"]) ||
    strtolower(trim($_SESSION["role"])) !== "teacher"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


require_once __DIR__ . "/../../model/dbConnect.php";


$teacher_id =
    (int)$_SESSION["userId"];


/*
|--------------------------------------------------------------------------
| Get teacher courses
|--------------------------------------------------------------------------
*/

$courses = array();


$sql = "
    SELECT id, course_code, course_name
    FROM courses
    WHERE teacher_id = $teacher_id
    ORDER BY id ASC
";


$result =
    mysqli_query($conn, $sql);


if ($result) {

    while (
        $row = mysqli_fetch_assoc($result)
    ) {

        $courses[] = $row;

    }

}


/*
|--------------------------------------------------------------------------
| Get loaded students
|--------------------------------------------------------------------------
*/

$students =
    isset($_SESSION["gradeStudents"])
    ? $_SESSION["gradeStudents"]
    : array();


$selectedCourse =
    isset($_SESSION["selectedCourse"])
    ? $_SESSION["selectedCourse"]
    : null;


$gradeMessage =
    isset($_SESSION["gradeMessage"])
    ? $_SESSION["gradeMessage"]
    : "";


$gradeError =
    isset($_SESSION["gradeError"])
    ? $_SESSION["gradeError"]
    : "";


unset($_SESSION["gradeMessage"]);
unset($_SESSION["gradeError"]);

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

    <h1>GRADE MANAGEMENT</h1>

</section>


<?php if ($gradeMessage !== ""): ?>

    <p style="
        text-align:center;
        color:green;
        font-weight:bold;
    ">

        <?php
        echo htmlspecialchars(
            $gradeMessage
        );
        ?>

    </p>

<?php endif; ?>


<?php if ($gradeError !== ""): ?>

    <p style="
        text-align:center;
        color:red;
        font-weight:bold;
    ">

        <?php
        echo htmlspecialchars(
            $gradeError
        );
        ?>

    </p>

<?php endif; ?>


<!--
|--------------------------------------------------------------------------
| Select Course
|--------------------------------------------------------------------------
-->

<section>

    <form
        method="post"
        action="/cms/controller/gradeController.php"
    >

        <section class="course_section">

            <div>

                <label for="course_id">
                    Course:
                </label>


                <select
                    name="course_id"
                    id="course_id"
                    required
                >

                    <option value="">
                        Select Course
                    </option>


                    <?php foreach (
                        $courses
                        as $course
                    ): ?>

                        <option
                            value="<?php
                                echo (int)$course["id"];
                            ?>"

                            <?php

                            if (
                                $selectedCourse !== null &&
                                (int)$selectedCourse["id"]
                                ===
                                (int)$course["id"]
                            ) {

                                echo "selected";

                            }

                            ?>
                        >

                            <?php

                            echo htmlspecialchars(
                                $course["course_code"]
                            );

                            ?>

                            -

                            <?php

                            echo htmlspecialchars(
                                $course["course_name"]
                            );

                            ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <input
                type="hidden"
                name="load_students"
                value="1"
            >


            <button type="submit">
                Load Students
            </button>

        </section>

    </form>

</section>


<!--
|--------------------------------------------------------------------------
| Students and Grades
|--------------------------------------------------------------------------
-->

<section class="material_table">


<?php if (
    $selectedCourse !== null
): ?>

    <h2>

        <?php

        echo htmlspecialchars(
            $selectedCourse["course_code"]
        );

        ?>

        -

        <?php

        echo htmlspecialchars(
            $selectedCourse["course_name"]
        );

        ?>

    </h2>


    <form
        method="post"
        action="/cms/controller/gradeController.php"
    >


        <input
            type="hidden"
            name="course_id"
            value="<?php
                echo (int)$selectedCourse["id"];
            ?>"
        >


        <input
            type="hidden"
            name="save_grades"
            value="1"
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

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>


            <?php if (
                count($students) === 0
            ): ?>

                <tr>

                    <td colspan="8">

                        No students enrolled
                        in this course.

                    </td>

                </tr>


            <?php else: ?>


                <?php

                $serial = 1;

                ?>


                <?php foreach (
                    $students
                    as $student
                ): ?>


                    <tr>

                        <td>

                            <?php
                            echo $serial;
                            ?>

                        </td>


                        <td>

                            <?php
                            echo (int)
                                $student["student_id"];
                            ?>


                            <input
                                type="hidden"
                                name="student_id[]"
                                value="<?php
                                    echo (int)
                                        $student["student_id"];
                                ?>"
                            >

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $student["student_name"]
                            );

                            ?>

                        </td>


                        <td>

                            <input
                                type="number"
                                name="mid[<?php
                                    echo (int)
                                        $student["student_id"];
                                ?>]"
                                value="<?php
                                    echo $student["mid"]
                                        !== null
                                        ? htmlspecialchars(
                                            $student["mid"]
                                        )
                                        : "";
                                ?>"
                                min="0"
                                max="100"
                                step="0.01"
                            >

                        </td>


                        <td>

                            <input
                                type="number"
                                name="final[<?php
                                    echo (int)
                                        $student["student_id"];
                                ?>]"
                                value="<?php
                                    echo $student["final"]
                                        !== null
                                        ? htmlspecialchars(
                                            $student["final"]
                                        )
                                        : "";
                                ?>"
                                min="0"
                                max="100"
                                step="0.01"
                            >

                        </td>


                        <td>

                            <?php

                            echo $student["marks"]
                                !== null
                                ? htmlspecialchars(
                                    $student["marks"]
                                )
                                : "0";

                            ?>

                        </td>


                        <td>

                            <?php

                            echo $student["grade"]
                                !== null
                                ? htmlspecialchars(
                                    $student["grade"]
                                )
                                : "-";

                            ?>

                        </td>


                        <td>

                            <button
                                type="submit"
                            >

                                Save

                            </button>

                        </td>

                    </tr>


                    <?php

                    $serial++;

                    ?>


                <?php endforeach; ?>


            <?php endif; ?>


            </tbody>

        </table>


        <?php if (
            count($students) > 0
        ): ?>

            <br>

            <button type="submit">

                Save Changes

            </button>

        <?php endif; ?>


    </form>


<?php else: ?>


    <p style="text-align:center;">

        Select a course and click
        <b>Load Students</b>.

    </p>


<?php endif; ?>


</section>


<br>


<p style="text-align:center;">

    <a
        href="/cms/view/teacher/teacherDashboard.php"
    >

        Back to Teacher Dashboard

    </a>

</p>


</body>

</html>