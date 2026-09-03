<?php

require_once __DIR__ . '/../../model/dbConnect.php';


function getTeacherCoursesForMaterial($teacherId)
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


function uploadMaterialData(
    $courseId,
    $teacherId,
    $title,
    $fileName
)
{
    global $conn;

    $title = mysqli_real_escape_string(
        $conn,
        $title
    );

    $fileName = mysqli_real_escape_string(
        $conn,
        $fileName
    );


    $sql = "INSERT INTO course_materials
            (course_id, teacher_id, title, file_name)
            VALUES
            ($courseId, $teacherId, '$title', '$fileName')";

    return mysqli_query($conn, $sql);
}


function getTeacherMaterials($teacherId)
{
    global $conn;

    $sql = "SELECT cm.id,
                   cm.title,
                   cm.file_name,
                   c.course_code,
                   c.course_name
            FROM course_materials cm
            JOIN courses c
            ON cm.course_id = c.id
            WHERE cm.teacher_id = $teacherId
            ORDER BY cm.id DESC";

    $result = mysqli_query($conn, $sql);

    $materials = array();

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {

            $materials[] = $row;
        }
    }

    return $materials;
}


function deleteMaterialData(
    $id,
    $teacherId
)
{
    global $conn;

    $sql = "DELETE FROM course_materials
            WHERE id = $id
            AND teacher_id = $teacherId";

    return mysqli_query($conn, $sql);
}

?>