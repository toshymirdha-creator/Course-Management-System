<?php

session_start();

if (
    !isset($_SESSION['isLoggedIn']) ||
    $_SESSION['isLoggedIn'] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

if (
    !isset($_SESSION['role']) ||
    strtolower(trim($_SESSION['role'])) !== "teacher"
) {
    header("Location: /cms/view/common/login.php");
    exit();
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

    <title>Course Drop Request Approval</title>

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

    <h1>Course Drop Request Approval</h1>

</section>


<section>

    <form>

        <section class="course_section">

            <div>

                <label for="C_ourse">
                    Status
                </label>

                <select
                    name="Course"
                    id="C_ourse"
                >

                    <option value="all">
                        All
                    </option>

                    <option value="pending">
                        Pending
                    </option>

                    <option value="approved">
                        Approved
                    </option>

                    <option value="rejected">
                        Rejected
                    </option>

                </select>

            </div>


            <button type="submit">
                Filter
            </button>

        </section>

    </form>

</section>


<section class="material_table">

    <form
        method="post"
        action="/cms/controller/dropControllerT.php"
    >

        <h2>Course Drop Requests</h2>


        <table>

            <thead>

                <tr>

                    <th>SI</th>

                    <th>Student ID</th>

                    <th>Student Name</th>

                    <th>Course</th>

                    <th>Request Date</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

                <tr>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td></td>

                    <td>

                        <button type="submit">
                            Approve
                        </button>

                        <button type="submit">
                            Reject
                        </button>

                    </td>

                </tr>

            </tbody>

        </table>

    </form>

</section>


</body>

</html>