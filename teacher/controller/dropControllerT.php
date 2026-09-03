<?php

session_start();

if (!isset($_SESSION['isLoggedIn']))
{
    header("Location: login.php");
    exit();
}

require_once "../model/grade.php";


if ($_SERVER["REQUEST_METHOD"] === "POST")
{

    /* Load Students */

    if (isset($_POST["load_students"]))
    {
        $course_id = $_POST["Course"];

        $_SESSION["course_id"] = $course_id;

        header("Location: ../view/gradeManagement.php");
        exit();
    }


    /* Save Grades */

    if (isset($_POST["save_grades"]))
    {
        $course_id = $_POST["course_id"];

        $student_ids = $_POST["student_id"];
        $mids = $_POST["mid"];
        $finals = $_POST["final"];

        for ($i = 0; $i < count($student_ids); $i++)
        {
            $student_id = $student_ids[$i];

            $mid = $mids[$i];
            $final = $finals[$i];

            if ($mid == "" || $final == "")
            {
                continue;
            }


            /* Validation */

            if ($mid < 0 || $mid > 100)
            {
                continue;
            }

            if ($final < 0 || $final > 100)
            {
                continue;
            }


            /* Calculate Average */

            $marks = ($mid + $final) / 2;


            /* Calculate Grade */

            if ($marks >= 80)
            {
                $grade = "A+";
            }
            else if ($marks >= 75)
            {
                $grade = "A";
            }
            else if ($marks >= 70)
            {
                $grade = "A-";
            }
            else if ($marks >= 65)
            {
                $grade = "B+";
            }
            else if ($marks >= 60)
            {
                $grade = "B";
            }
            else if ($marks >= 50)
            {
                $grade = "C";
            }
            else
            {
                $grade = "F";
            }


            /* Check Existing Grade */

            $existing = getGradeByStudentCourse($student_id, $course_id);


            if ($existing)
            {
                updateGrade(
                    $existing['id'],
                    $mid,
                    $final,
                    $grade,
                    $marks
                );
            }
            else
            {
                saveGrade(
                    $student_id,
                    $course_id,
                    $mid,
                    $final,
                    $grade,
                    $marks
                );
            }
        }


        header("Location: ../view/gradeManagement.php");
        exit();
    }


    /* Delete Grade */

    if (isset($_POST["delete_grade"]))
    {
        $id = $_POST["id"];

        deleteGrade($id);

        header("Location: ../view/gradeManagement.php");
        exit();
    }

}

?>