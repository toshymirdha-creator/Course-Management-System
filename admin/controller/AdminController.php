<?php

session_start();

require_once "../model/user.php";
require_once "../model/course.php";
require_once "../model/courseDrop.php";



 //  ADMIN ACCESS CHECK
   

if (
    !isset($_SESSION["isLoggedIn"])
    || $_SESSION["isLoggedIn"] !== true
    || !isset($_SESSION["role"])
    || $_SESSION["role"] !== "Admin"
) {
    header("Location: ../../common/login.php");
    exit();
}


$action = isset($_GET["action"]) ? $_GET["action"] : "";



  // USER MANAGEMENT
  

if ($action === "users") {

    $_SESSION["users"] = getAllUsers();

    header("Location: ../view/admin/user-management.php");
    exit();
}


if ($action === "addUser") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $role = trim($_POST["role"]);


        if ($name === "" || $email === "" || $role === "") {

            $_SESSION["userError"] = "All fields are required.";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $_SESSION["userError"] = "Invalid email address.";

        } else {

            if (addUserData($name, $email, $role)) {

                $_SESSION["userMessage"] = "User added successfully.";

            } else {

                $_SESSION["userError"] = "Failed to add user.";
            }
        }
    }

    header("Location: AdminController.php?action=users");
    exit();
}


/* =========================
   COURSE MANAGEMENT
   ========================= */

if ($action === "courses") {

    $_SESSION["courses"] = getAllCourses();

    header("Location: ../view/admin/course-management.php");
    exit();
}


if ($action === "addCourse") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $code = trim($_POST["code"]);
        $name = trim($_POST["name"]);
        $credit = trim($_POST["credit"]);
        $teacher = trim($_POST["teacher"]);


        if (
            $code === ""
            || $name === ""
            || $credit === ""
            || $teacher === ""
        ) {

            $_SESSION["courseError"] = "All fields are required.";

        } else {

            if (addCourseData($code, $name, $credit, $teacher)) {

                $_SESSION["courseMessage"] = "Course added successfully.";

            } else {

                $_SESSION["courseError"] = "Failed to add course.";
            }
        }
    }

    header("Location: AdminController.php?action=courses");
    exit();
}


if ($action === "deleteCourse") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $id = isset($_POST["id"])
            ? (int)$_POST["id"]
            : 0;


        if ($id > 0 && deleteCourseById($id)) {

            $_SESSION["courseMessage"] = "Course deleted successfully.";

        } else {

            $_SESSION["courseError"] = "Failed to delete course.";
        }
    }

    header("Location: AdminController.php?action=courses");
    exit();
}



  // COURSE DROP APPROVAL
  

if ($action === "courseDrops") {

    $_SESSION["courseDrops"] = getAllCourseDrops();

    header("Location: ../view/admin/course-drop-approval.php");
    exit();
}


if ($action === "approveCourseDrop") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $id = isset($_POST["id"])
            ? (int)$_POST["id"]
            : 0;


        if ($id > 0 && approveCourseDropById($id)) {

            $_SESSION["dropMessage"] =
                "Course drop request approved.";

        } else {

            $_SESSION["dropError"] =
                "Failed to approve request.";
        }
    }

    header("Location: AdminController.php?action=courseDrops");
    exit();
}


if ($action === "rejectCourseDrop") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $id = isset($_POST["id"])
            ? (int)$_POST["id"]
            : 0;


        if ($id > 0 && rejectCourseDropById($id)) {

            $_SESSION["dropMessage"] =
                "Course drop request rejected.";

        } else {

            $_SESSION["dropError"] =
                "Failed to reject request.";
        }
    }

    header("Location: AdminController.php?action=courseDrops");
    exit();
}



 //  VIEW PROFILE
   

if ($action === "profile") {

    $userId = isset($_SESSION["user_id"])
        ? (int)$_SESSION["user_id"]
        : 0;


    if ($userId > 0) {

        $_SESSION["profile"] = getUserById($userId);
    }


    header("Location: ../view/admin/profile/view-profile.php");
    exit();
}



  // EDIT PROFILE
  

if ($action === "editProfile") {

    $userId = isset($_SESSION["user_id"])
        ? (int)$_SESSION["user_id"]
        : 0;


    if ($userId > 0) {

        $_SESSION["profile"] = getUserById($userId);
    }


    header("Location: ../view/admin/profile/edit-profile.php");
    exit();
}



   //UPDATE NAME
 

if ($action === "updateName") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = trim($_POST["name"]);


        $userId = isset($_SESSION["user_id"])
            ? (int)$_SESSION["user_id"]
            : 0;


        if ($name === "") {

            $_SESSION["profileError"] =
                "Name is required.";

        } elseif ($userId <= 0) {

            $_SESSION["profileError"] =
                "User not found.";

        } elseif (updateUserName($userId, $name)) {

            $_SESSION["name"] = $name;

            $_SESSION["profileMessage"] =
                "Name updated successfully.";

        } else {

            $_SESSION["profileError"] =
                "Failed to update name.";
        }
    }


    header("Location: AdminController.php?action=editProfile");
    exit();
}



  // UPDATE EMAIL - AJAX + JSON
   

if ($action === "updateEmail") {

    header("Content-Type: application/json");


    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        echo json_encode(array(
            "success" => false,
            "message" => "Invalid request."
        ));

        exit();
    }


    $email = trim($_POST["email"]);


    $userId = isset($_SESSION["user_id"])
        ? (int)$_SESSION["user_id"]
        : 0;


    if ($email === "") {

        echo json_encode(array(
            "success" => false,
            "message" => "Email is required."
        ));

        exit();

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo json_encode(array(
            "success" => false,
            "message" => "Invalid email address."
        ));

        exit();

    } elseif ($userId <= 0) {

        echo json_encode(array(
            "success" => false,
            "message" => "User not found."
        ));

        exit();

    } elseif (updateUserEmail($userId, $email)) {

        $_SESSION["email"] = $email;

        echo json_encode(array(
            "success" => true,
            "message" => "Email updated successfully."
        ));

        exit();

    } else {

        echo json_encode(array(
            "success" => false,
            "message" => "Failed to update email."
        ));

        exit();
    }
}

?>