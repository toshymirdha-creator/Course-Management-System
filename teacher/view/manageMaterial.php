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


$courses =
    getTeacherCoursesForMaterial(
        $teacherId
    );


$message = "";


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


    if (
        $courseId === ""
        || $title === ""
        || !isset($_FILES['material'])
    ) {

        $message =
            "Please fill up all fields";

    }
    else {

        $fileName =
            $_FILES['material']['name'];

        $tmpName =
            $_FILES['material']['tmp_name'];


        $extension =
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            );


        if (
            $extension !== "pdf"
            && $extension !== "pptx"
        ) {

            $message =
                "Only PDF and PPTX files are allowed";

        }
        else {

            $uploadFolder =
                __DIR__
                . '/../../uploads/';


            if (
                !is_dir($uploadFolder)
            ) {

                mkdir(
                    $uploadFolder,
                    0777,
                    true
                );
            }


            $newFileName =
                time()
                . "_"
                . basename($fileName);


            $uploadPath =
                $uploadFolder
                . $newFileName;


            if (
                move_uploaded_file(
                    $tmpName,
                    $uploadPath
                )
            ) {

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


if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['delete'])
) {

    $id = (int)$_POST['delete'];


    $result =
        deleteMaterialData(
            $id,
            $teacherId
        );


    if ($result) {

        $message =
            "Material deleted successfully";

    }
    else {

        $message =
            "Material delete failed";
    }
}


$materials =
    getTeacherMaterials(
        $teacherId
    );

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Course Material Management</title>

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

<h1>Course Material Management</h1>

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
    action="manageMaterial.php"
    enctype="multipart/form-data"
    onsubmit="return validateMaterialForm(this)"
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
>

</div>


</section>


<section class="file_material">

<label for="m_aterial">
    Upload Material:
</label>


<input
    type="file"
    name="material"
    id="m_aterial"
    accept=".pdf,.pptx"
>


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


<section class="material_table">

<h2>Course Materials</h2>


<table>

<thead>

<tr>

<th>SI</th>

<th>Course</th>

<th>Title</th>

<th>File Name</th>

<th>Action</th>

</tr>

</thead>


<tbody>

<?php

if (empty($materials)) {

    echo "<tr>";

    echo "<td colspan='5'>";
    echo "No course materials available";
    echo "</td>";

    echo "</tr>";

}
else {

    $si = 1;


    foreach ($materials as $material) {

        echo "<tr>";

        echo "<td>";
        echo $si;
        echo "</td>";


        echo "<td>";

        echo htmlspecialchars(
            $material['course_code']
        );

        echo " - ";

        echo htmlspecialchars(
            $material['course_name']
        );

        echo "</td>";


        echo "<td>";

        echo htmlspecialchars(
            $material['title']
        );

        echo "</td>";


        echo "<td>";

        echo htmlspecialchars(
            $material['file_name']
        );

        echo "</td>";


        echo "<td>";

        echo "<a
                href='/cms/uploads/"
            . htmlspecialchars(
                $material['file_name']
            )
            . "'
                target='_blank'
            >
                View
              </a>";


        echo " ";


        echo "<form
                method='post'
                action='manageMaterial.php'
                style='display:inline;'
            >";

        echo "<button
                type='submit'
                name='delete'
                value='"
            . htmlspecialchars(
                $material['id']
            )
            . "'>
                Delete
              </button>";

        echo "</form>";


        echo "</td>";


        echo "</tr>";

        $si++;
    }
}

?>

</tbody>

</table>

</section>


<br>

<center>

<a href="teacherDashboard.php">
    Back to Dashboard
</a>

</center>

<script src="/cms/js/form-validation.js"></script>

</body>

</html>