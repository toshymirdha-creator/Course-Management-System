<?php

session_start();

require_once __DIR__ . "/../model/courseMaterial.php";


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


$action = isset($_GET["action"])
    ? $_GET["action"]
    : "";


/*
|--------------------------------------------------------------------------
| Show Materials
|--------------------------------------------------------------------------
*/

if ($action === "materials") {

    $_SESSION["materials"] =
        getCourseMaterials($teacher_id);

    header(
        "Location: /cms/view/teacher/manageMaterial.php"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Upload Material
|--------------------------------------------------------------------------
*/

if ($action === "upload") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    $course_id = isset($_POST["course_id"])
        ? (int)$_POST["course_id"]
        : 0;


    $title = isset($_POST["title"])
        ? trim($_POST["title"])
        : "";


    if ($course_id <= 0 || $title === "") {

        $_SESSION["materialError"] =
            "Please fill up all fields.";

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    if (
        !isset($_FILES["material"]) ||
        $_FILES["material"]["error"] !== UPLOAD_ERR_OK
    ) {

        $_SESSION["materialError"] =
            "Please select a file.";

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Check selected course belongs to this teacher
    |--------------------------------------------------------------------------
    */

    $courses = getCoursesForTeacher($teacher_id);

    $courseExists = false;

    foreach ($courses as $course) {

        if ((int)$course["id"] === $course_id) {

            $courseExists = true;

            break;
        }
    }


    if (!$courseExists) {

        $_SESSION["materialError"] =
            "Invalid course selected.";

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | File information
    |--------------------------------------------------------------------------
    */

    $originalFileName =
        $_FILES["material"]["name"];

    $tmpPath =
        $_FILES["material"]["tmp_name"];


    $extension = strtolower(
        pathinfo(
            $originalFileName,
            PATHINFO_EXTENSION
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Only PDF and PPTX
    |--------------------------------------------------------------------------
    */

    if (
        $extension !== "pdf" &&
        $extension !== "pptx"
    ) {

        $_SESSION["materialError"] =
            "Only PDF and PPTX files can be uploaded.";

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Upload folder
    |--------------------------------------------------------------------------
    */

    $uploadFolder =
        __DIR__ . "/../uploads/";


    if (!is_dir($uploadFolder)) {

        mkdir(
            $uploadFolder,
            0777,
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create safe file name
    |--------------------------------------------------------------------------
    */

    $safeFileName =
        basename($originalFileName);


    $destination =
        $uploadFolder . $safeFileName;


    /*
    |--------------------------------------------------------------------------
    | If same file already exists,
    | create a unique file name
    |--------------------------------------------------------------------------
    */

    if (file_exists($destination)) {

        $fileBaseName =
            pathinfo(
                $safeFileName,
                PATHINFO_FILENAME
            );

        $fileExtension =
            pathinfo(
                $safeFileName,
                PATHINFO_EXTENSION
            );

        $safeFileName =
            $fileBaseName .
            "_" .
            time() .
            "." .
            $fileExtension;

        $destination =
            $uploadFolder . $safeFileName;
    }


    /*
    |--------------------------------------------------------------------------
    | Move uploaded file
    |--------------------------------------------------------------------------
    */

    if (!move_uploaded_file(
        $tmpPath,
        $destination
    )) {

        $_SESSION["materialError"] =
            "File upload failed.";

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | Save database record
    |--------------------------------------------------------------------------
    */

    $result = addCourseMaterial(
        $course_id,
        $teacher_id,
        $title,
        $safeFileName
    );


    if ($result) {

        $_SESSION["materialMessage"] =
            "Course material uploaded successfully.";

    } else {

        /*
        | If database insert fails,
        | remove uploaded file
        */

        if (file_exists($destination)) {
            unlink($destination);
        }

        $_SESSION["materialError"] =
            "File uploaded but database record could not be saved.";
    }


    header(
        "Location: /cms/view/teacher/manageMaterial.php"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Delete Material
|--------------------------------------------------------------------------
*/

if ($action === "delete") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        header(
            "Location: /cms/view/teacher/manageMaterial.php"
        );

        exit();
    }


    $id = isset($_POST["id"])
        ? (int)$_POST["id"]
        : 0;


    if (
        $id > 0 &&
        deleteCourseMaterial(
            $id,
            $teacher_id
        )
    ) {

        $_SESSION["materialMessage"] =
            "Course material deleted successfully.";

    } else {

        $_SESSION["materialError"] =
            "Failed to delete course material.";
    }


    header(
        "Location: /cms/view/teacher/manageMaterial.php"
    );

    exit();
}


/*
|--------------------------------------------------------------------------
| Default
|--------------------------------------------------------------------------
*/

$_SESSION["materials"] =
    getCourseMaterials($teacher_id);

header(
    "Location: /cms/view/teacher/manageMaterial.php"
);

exit();

?>