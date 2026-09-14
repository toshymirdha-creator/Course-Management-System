<?php

session_start();

require_once __DIR__ . "/../model/dbConnect.php";


/*
|--------------------------------------------------------------------------
| Teacher Login Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true ||
    !isset($_SESSION["role"]) ||
    strtolower(trim($_SESSION["role"])) !== "teacher"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


$teacher_id = (int)$_SESSION["userId"];


/*
|--------------------------------------------------------------------------
| Load Students
|--------------------------------------------------------------------------
*/

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["load_students"])
) {

    $course_id = isset($_POST["course_id"])
        ? (int)$_POST["course_id"]
        : 0;


    if ($course_id <= 0) {

        $_SESSION["gradeError"] =
            "Please select a course.";

        header(
            "Location: /cms/view/teacher/gradeManagement.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Make sure selected course belongs to logged-in teacher
    |--------------------------------------------------------------------------
    */

    $courseSql = "
        SELECT id, course_code, course_name
        FROM courses
        WHERE id = $course_id
        AND teacher_id = $teacher_id
    ";

    $courseResult =
        mysqli_query($conn, $courseSql);


    if (
        !$courseResult ||
        mysqli_num_rows($courseResult) === 0
    ) {

        $_SESSION["gradeError"] =
            "Invalid course selected.";

        header(
            "Location: /cms/view/teacher/gradeManagement.php"
        );

        exit();
    }


    $course =
        mysqli_fetch_assoc($courseResult);


    /*
    |--------------------------------------------------------------------------
    | Get enrolled students
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT
            u.id AS student_id,
            u.name AS student_name,
            g.id AS grade_id,
            g.mid,
            g.final,
            g.marks,
            g.grade
        FROM enrollments e

        INNER JOIN users u
            ON e.student_id = u.id

        LEFT JOIN grades g
            ON g.student_id = e.student_id
            AND g.course_id = e.course_id

        WHERE e.course_id = $course_id
        AND LOWER(TRIM(u.role)) = 'student'

        ORDER BY u.id ASC
    ";


    $result =
        mysqli_query($conn, $sql);


    $students = array();


    if ($result) {

        while (
            $row = mysqli_fetch_assoc($result)
        ) {

            $students[] = $row;

        }

    }


    $_SESSION["selectedCourse"] = $course;

    $_SESSION["gradeStudents"] = $students;


    header(
        "Location: /cms/view/teacher/gradeManagement.php"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Save Grades
|--------------------------------------------------------------------------
*/

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["save_grades"])
) {

    $course_id = isset($_POST["course_id"])
        ? (int)$_POST["course_id"]
        : 0;


    if ($course_id <= 0) {

        $_SESSION["gradeError"] =
            "Invalid course.";

        header(
            "Location: /cms/view/teacher/gradeManagement.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Check course belongs to teacher
    |--------------------------------------------------------------------------
    */

    $courseSql = "
        SELECT id
        FROM courses
        WHERE id = $course_id
        AND teacher_id = $teacher_id
    ";

    $courseResult =
        mysqli_query($conn, $courseSql);


    if (
        !$courseResult ||
        mysqli_num_rows($courseResult) === 0
    ) {

        $_SESSION["gradeError"] =
            "You cannot manage grades for this course.";

        header(
            "Location: /cms/view/teacher/gradeManagement.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Student IDs
    |--------------------------------------------------------------------------
    */

    $student_ids =
        isset($_POST["student_id"])
        ? $_POST["student_id"]
        : array();


    $mids =
        isset($_POST["mid"])
        ? $_POST["mid"]
        : array();


    $finals =
        isset($_POST["final"])
        ? $_POST["final"]
        : array();


    foreach (
        $student_ids
        as $student_id
    ) {

        $student_id =
            (int)$student_id;


        $mid =
            isset($mids[$student_id])
            ? (float)$mids[$student_id]
            : 0;


        $final =
            isset($finals[$student_id])
            ? (float)$finals[$student_id]
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Validate marks
        |--------------------------------------------------------------------------
        */

        if ($mid < 0 || $mid > 100) {
            $mid = 0;
        }

        if ($final < 0 || $final > 100) {
            $final = 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Total marks
        |--------------------------------------------------------------------------
        */

        $marks =
            $mid + $final;


        /*
        |--------------------------------------------------------------------------
        | Calculate grade
        |
        | Total out of 200
        |--------------------------------------------------------------------------
        */

        if ($marks >= 160) {

            $grade = "A+";

        } elseif ($marks >= 140) {

            $grade = "A";

        } elseif ($marks >= 130) {

            $grade = "A-";

        } elseif ($marks >= 120) {

            $grade = "B+";

        } elseif ($marks >= 110) {

            $grade = "B";

        } elseif ($marks >= 100) {

            $grade = "B-";

        } elseif ($marks >= 90) {

            $grade = "C+";

        } elseif ($marks >= 80) {

            $grade = "C";

        } elseif ($marks >= 70) {

            $grade = "D";

        } else {

            $grade = "F";
        }


        /*
        |--------------------------------------------------------------------------
        | Check if grade already exists
        |--------------------------------------------------------------------------
        */

        $checkSql = "
            SELECT id
            FROM grades
            WHERE student_id = $student_id
            AND course_id = $course_id
        ";


        $checkResult =
            mysqli_query($conn, $checkSql);


        if (
            $checkResult &&
            mysqli_num_rows($checkResult) > 0
        ) {

            $existing =
                mysqli_fetch_assoc(
                    $checkResult
                );

            $grade_id =
                (int)$existing["id"];


            /*
            | Update existing grade
            */

            $updateSql = "
                UPDATE grades
                SET
                    mid = $mid,
                    final = $final,
                    marks = $marks,
                    grade = '$grade'
                WHERE id = $grade_id
            ";


            mysqli_query(
                $conn,
                $updateSql
            );

        } else {

            /*
            | Insert new grade
            */

            $insertSql = "
                INSERT INTO grades
                (
                    student_id,
                    course_id,
                    grade,
                    marks,
                    mid,
                    final
                )
                VALUES
                (
                    $student_id,
                    $course_id,
                    '$grade',
                    $marks,
                    $mid,
                    $final
                )
            ";


            mysqli_query(
                $conn,
                $insertSql
            );
        }
    }


    $_SESSION["gradeMessage"] =
        "Grades saved successfully.";


    /*
    |--------------------------------------------------------------------------
    | Reload students after saving
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT
            u.id AS student_id,
            u.name AS student_name,
            g.id AS grade_id,
            g.mid,
            g.final,
            g.marks,
            g.grade
        FROM enrollments e

        INNER JOIN users u
            ON e.student_id = u.id

        LEFT JOIN grades g
            ON g.student_id = e.student_id
            AND g.course_id = e.course_id

        WHERE e.course_id = $course_id
        AND LOWER(TRIM(u.role)) = 'student'

        ORDER BY u.id ASC
    ";


    $result =
        mysqli_query($conn, $sql);


    $students = array();


    if ($result) {

        while (
            $row = mysqli_fetch_assoc($result)
        ) {

            $students[] = $row;

        }

    }


    $_SESSION["gradeStudents"] =
        $students;


    $courseSql = "
        SELECT id, course_code, course_name
        FROM courses
        WHERE id = $course_id
    ";


    $courseResult =
        mysqli_query($conn, $courseSql);


    if ($courseResult) {

        $_SESSION["selectedCourse"] =
            mysqli_fetch_assoc(
                $courseResult
            );

    }


    header(
        "Location: /cms/view/teacher/gradeManagement.php"
    );

    exit();
}


?>