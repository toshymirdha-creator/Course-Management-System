<?php

session_start();

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


require_once __DIR__ . "/../../model/courseMaterial.php";


$teacher_id = (int)$_SESSION["userId"];


/*
|--------------------------------------------------------------------------
| Get teacher's courses
|--------------------------------------------------------------------------
*/

$courses =
    getCoursesForTeacher($teacher_id);


/*
|--------------------------------------------------------------------------
| Get uploaded materials
|--------------------------------------------------------------------------
*/

$materials =
    getCourseMaterials($teacher_id);


/*
|--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
*/

$materialMessage =
    isset($_SESSION["materialMessage"])
    ? $_SESSION["materialMessage"]
    : "";

$materialError =
    isset($_SESSION["materialError"])
    ? $_SESSION["materialError"]
    : "";


unset($_SESSION["materialMessage"]);
unset($_SESSION["materialError"]);

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

    <h1>COURSE MATERIAL MANAGEMENT</h1>

</section>


<?php if ($materialMessage !== ""): ?>

    <p style="
        text-align:center;
        color:green;
        font-weight:bold;
    ">

        <?php
        echo htmlspecialchars(
            $materialMessage
        );
        ?>

    </p>

<?php endif; ?>


<?php if ($materialError !== ""): ?>

    <p style="
        text-align:center;
        color:red;
        font-weight:bold;
    ">

        <?php
        echo htmlspecialchars(
            $materialError
        );
        ?>

    </p>

<?php endif; ?>


<!--
|--------------------------------------------------------------------------
| Upload Form
|--------------------------------------------------------------------------
-->

<section>

    <form
        method="post"
        action="/cms/controller/uploadMaterialController.php?action=upload"
        enctype="multipart/form-data"
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


        </section>


        <section class="file_material">

            <br>

            <label for="title">
                Material Title:
            </label>

            <br>

            <input
                type="text"
                name="title"
                id="title"
                placeholder="Enter material title"
                required
            >

            <br><br>


            <label for="m_aterial">
                Upload Material:
            </label>

            <br>

            <input
                type="file"
                name="material"
                id="m_aterial"
                accept=".pdf,.pptx"
                required
            >

            <br><br>

            <button type="submit">
                Upload
            </button>

        </section>

    </form>

</section>


<!--
|--------------------------------------------------------------------------
| Course Materials Table
|--------------------------------------------------------------------------
-->

<section class="material_table">

    <h2>Course Materials</h2>


    <table>

        <thead>

            <tr>

                <th>ID</th>

                <th>Course</th>

                <th>Title</th>

                <th>File Name</th>

                <th>Action</th>

            </tr>

        </thead>


        <tbody>


        <?php if (
            count($materials) === 0
        ): ?>

            <tr>

                <td colspan="5">

                    No course materials uploaded yet.

                </td>

            </tr>


        <?php else: ?>


            <?php foreach (
                $materials
                as $material
            ): ?>

                <tr>

                    <td>

                        <?php
                        echo (int)$material["id"];
                        ?>

                    </td>


                    <td>

                        <?php

                        echo htmlspecialchars(
                            $material["course_code"]
                        );

                        ?>

                        -

                        <?php

                        echo htmlspecialchars(
                            $material["course_name"]
                        );

                        ?>

                    </td>


                    <td>

                        <?php

                        echo htmlspecialchars(
                            $material["title"]
                        );

                        ?>

                    </td>


                    <td>

                        <?php

                        echo htmlspecialchars(
                            $material["file_name"]
                        );

                        ?>

                    </td>


                    <td>


                        <a
                            href="/cms/uploads/<?php
                                echo rawurlencode(
                                    $material["file_name"]
                                );
                            ?>"
                            target="_blank"
                        >

                            <button type="button">
                                View
                            </button>

                        </a>


                        <form
                            method="post"
                            action="/cms/controller/uploadMaterialController.php?action=delete"
                            style="
                                display:inline;
                                padding:0;
                                margin:0;
                                border:none;
                                background:none;
                            "
                            onsubmit="
                                return confirm(
                                    'Are you sure you want to delete this material?'
                                );
                            "
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php
                                    echo (int)$material["id"];
                                ?>"
                            >

                            <button
                                type="submit"
                            >
                                Delete
                            </button>

                        </form>


                    </td>

                </tr>

            <?php endforeach; ?>


        <?php endif; ?>


        </tbody>

    </table>

</section>


<br>

<p style="text-align:center;">

    <a href="/cms/view/teacher/teacherDashboard.php">
        Back to Teacher Dashboard
    </a>

</p>


</body>

</html>