<?php

session_start();

require_once __DIR__ . '/../model/material.php';


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

$message = "";


// Get Teacher Courses

$courses = getTeacherCoursesForMaterial(
    $teacherId
);


// =========================
// Upload Material
// =========================

if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['upload'])
) {

    $courseId = isset($_POST['course'])
        ? trim($_POST['course'])
        : "";

    $title = isset($_POST['title'])
        ? trim($_POST['title'])
        : "";


    // PHP Validation

    if ($courseId === "") {

        $message =
            "Please select a course";

    }

    elseif ($title === "") {

        $message =
            "Please enter material title";

    }

    elseif (
        !isset($_FILES['material'])
        || $_FILES['material']['error'] !== UPLOAD_ERR_OK
    ) {

        $message =
            "Please select a file";

    }

    else {

        $fileName =
            $_FILES['material']['name'];

        $tmpName =
            $_FILES['material']['tmp_name'];


        // Get Extension

        $extension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        // Only PDF and PPTX

        if (
            $extension !== "pdf"
            && $extension !== "pptx"
        ) {

            $message =
                "Only PDF and PPTX files are allowed";

        }

        else {

            // Upload Folder

            $uploadFolder =
                __DIR__ . '/../../uploads/';


            // Create Folder if not exists

            if (
                !is_dir($uploadFolder)
            ) {

                mkdir(
                    $uploadFolder,
                    0777,
                    true
                );
            }


            // Create Unique File Name

            $newFileName =
                time()
                . "_"
                . basename($fileName);


            $uploadPath =
                $uploadFolder
                . $newFileName;


            // Move File

            if (
                move_uploaded_file(
                    $tmpName,
                    $uploadPath
                )
            ) {


                // Save File Information in Database

                $result =
                    uploadMaterialData(
                        $courseId,
                        $teacherId,
                        $title,
                        $newFileName
                    );


                if ($result) {

                    $message =
                        "Material uploaded successfully";

                }

                else {

                    // Delete uploaded file
                    // if database insert fails

                    if (
                        file_exists($uploadPath)
                    ) {

                        unlink($uploadPath);
                    }


                    $message =
                        "Database insert failed";
                }

            }

            else {

                $message =
                    "File upload failed";
            }
        }
    }
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

    <title>Upload Course Material</title>


    <!-- Shared CSS -->

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

    <h1>Upload Course Material</h1>

</section>



<?php

if ($message !== "") {

    echo "<p>";

    echo htmlspecialchars($message);

    echo "</p>";
}

?>



<section>


<form
    method="post"
    action="uploadMaterial.php"
    enctype="multipart/form-data"
    onsubmit="return validateMaterialForm(this)"
    novalidate
>


<section class="course_section">


<div>

    <label for="course">

        Course:

    </label>


    <select
        name="course"
        id="course"
    >

        <option value="">

            Select Course

        </option>


        <?php

        foreach ($courses as $course) {

            echo "<option value='"
                . htmlspecialchars(
                    $course['id']
                )
                . "'>";

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



<div>

    <label for="title">

        Material Title:

    </label>


    <input
        type="text"
        name="title"
        id="title"
        placeholder="Enter material title"
    >

</div>


</section>



<section class="file_material">


    <label for="material">

        Upload Material:

    </label>


    <input
        type="file"
        name="material"
        id="material"
        accept=".pdf,.pptx"
    >


    <br><br>


    <small>

        Only PDF and PPTX files are allowed.

    </small>


    <br><br>


    <button
        type="submit"
        name="upload"
        value="1"
    >

        Upload

    </button>


</section>


</form>


</section>



<br>



<center>

    <a href="teacherDashboard.php">

        Back to Dashboard

    </a>

    <br><br>

    <a href="manageMaterial.php">

        Manage Course Material

    </a>

</center>



<!-- Shared JS -->

<script src="/cms/js/form-validation.js"></script>


</body>

</html>