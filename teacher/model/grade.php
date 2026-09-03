<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getTeacherCourses($teacherId)
{
    global $conn;

    $sql = "SELECT id, course_code, course_name
            FROM courses
            WHERE teacher_id = $teacherId";

    $result = mysqli_query($conn, $sql);

    $courses = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $courses[] = $row;
        }
    }

    return $courses;
}


function getStudentsForGrade($courseId)
{
    global $conn;

    $sql = "SELECT e.student_id,
                   u.name,
                   e.course_id,
                   g.id AS grade_id,
                   g.mid,
                   g.final,
                   g.marks,
                   g.grade
            FROM enrollments e
            JOIN users u
            ON e.student_id = u.id
            LEFT JOIN grades g
            ON e.student_id = g.student_id
            AND e.course_id = g.course_id
            WHERE e.course_id = $courseId";

    $result = mysqli_query($conn, $sql);

    $students = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $students[] = $row;
        }
    }

    return $students;
}


function saveGrade(
    $studentId,
    $courseId,
    $mid,
    $final,
    $marks,
    $grade
)
{
    global $conn;

    $checkSql = "SELECT id
                 FROM grades
                 WHERE student_id = $studentId
                 AND course_id = $courseId";

    $checkResult = mysqli_query($conn, $checkSql);


    if (
        $checkResult
        && mysqli_num_rows($checkResult) > 0
    ) {

        $row = mysqli_fetch_assoc($checkResult);

        $id = $row['id'];

        $sql = "UPDATE grades
                SET mid = $mid,
                    final = $final,
                    marks = $marks,
                    grade = '$grade'
                WHERE id = $id";

    }
    else {

        $sql = "INSERT INTO grades
                (student_id, course_id, grade, marks, mid, final)
                VALUES
                ($studentId, $courseId, '$grade', $marks, $mid, $final)";
    }

    return mysqli_query($conn, $sql);
}

?>