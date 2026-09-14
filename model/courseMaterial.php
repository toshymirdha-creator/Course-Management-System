<?php

require_once __DIR__ . "/dbConnect.php";


function getCoursesForTeacher($teacher_id)
{
    global $conn;

    $teacher_id = (int)$teacher_id;

    $courses = array();

    $sql = "
        SELECT id, course_code, course_name
        FROM courses
        WHERE teacher_id = $teacher_id
        ORDER BY id ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $courses[] = $row;

        }

    }

    return $courses;
}


function addCourseMaterial(
    $course_id,
    $teacher_id,
    $title,
    $file_name
) {
    global $conn;

    $course_id = (int)$course_id;
    $teacher_id = (int)$teacher_id;

    $title = mysqli_real_escape_string(
        $conn,
        $title
    );

    $file_name = mysqli_real_escape_string(
        $conn,
        $file_name
    );

    $sql = "
        INSERT INTO course_materials
        (
            course_id,
            teacher_id,
            title,
            file_name
        )
        VALUES
        (
            $course_id,
            $teacher_id,
            '$title',
            '$file_name'
        )
    ";

    return mysqli_query($conn, $sql);
}


function getCourseMaterials($teacher_id)
{
    global $conn;

    $teacher_id = (int)$teacher_id;

    $materials = array();

    $sql = "
        SELECT
            cm.id,
            cm.course_id,
            cm.teacher_id,
            cm.title,
            cm.file_name,
            c.course_code,
            c.course_name
        FROM course_materials cm
        LEFT JOIN courses c
            ON cm.course_id = c.id
        WHERE cm.teacher_id = $teacher_id
        ORDER BY cm.id DESC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $materials[] = $row;

        }

    }

    return $materials;
}


function deleteCourseMaterial($id, $teacher_id)
{
    global $conn;

    $id = (int)$id;
    $teacher_id = (int)$teacher_id;

    $sql = "
        SELECT file_name
        FROM course_materials
        WHERE id = $id
        AND teacher_id = $teacher_id
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        return false;
    }

    $row = mysqli_fetch_assoc($result);

    $file_name = $row["file_name"];

    $deleteSql = "
        DELETE FROM course_materials
        WHERE id = $id
        AND teacher_id = $teacher_id
    ";

    if (!mysqli_query($conn, $deleteSql)) {
        return false;
    }

    $filePath = __DIR__ . "/../uploads/" . basename($file_name);

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    return true;
}

?>