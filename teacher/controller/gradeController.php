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


// =========================
// Load Students
// =========================

if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['load_students'])
) {

    $courseId = isset($_POST['course'])
        ? trim($_POST['course'])
        : "";

    if ($courseId === "") {

        header("Location: ../view/gradeManagement.php");

        exit();
    }


    $_SESSION['selected_course'] = $courseId;

    header(
        "Location: ../view/gradeManagement.php"
    );

    exit();
}


// =========================
// Save Grades
// =========================

if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['save_grades'])
) {

    $courseId = isset($_POST['course_id'])
        ? trim($_POST['course_id'])
        : "";

    $studentIds = isset($_POST['student_id'])
        ? $_POST['student_id']
        : array();

    $mids = isset($_POST['mid'])
        ? $_POST['mid']
        : array();

    $finals = isset($_POST['final'])
        ? $_POST['final']
        : array();


    if ($courseId !== "") {

        for (
            $i = 0;
            $i < count($studentIds);
            $i++
        ) {

            $studentId = (int)$studentIds[$i];

            $mid = isset($mids[$i])
                ? (int)$mids[$i]
                : 0;

            $final = isset($finals[$i])
                ? (int)$finals[$i]
                : 0;


            $marks = $mid + $final;


            if ($marks >= 80) {

                $grade = "A+";

            }
            elseif ($marks >= 75) {

                $grade = "A";

            }
            elseif ($marks >= 70) {

                $grade = "A-";

            }
            elseif ($marks >= 65) {

                $grade = "B+";

            }
            elseif ($marks >= 60) {

                $grade = "B";

            }
            elseif ($marks >= 55) {

                $grade = "B-";

            }
            elseif ($marks >= 50) {

                $grade = "C+";

            }
            elseif ($marks >= 45) {

                $grade = "C";

            }
            elseif ($marks >= 40) {

                $grade = "D";

            }
            else {

                $grade = "F";
            }


            saveGrade(
                $studentId,
                $courseId,
                $mid,
                $final,
                $marks,
                $grade
            );
        }
    }


    $_SESSION['gradeMessage'] =
        "Grades saved successfully";


    $_SESSION['selected_course'] = $courseId;


    header(
        "Location: ../view/gradeManagement.php"
    );

    exit();
}

?>