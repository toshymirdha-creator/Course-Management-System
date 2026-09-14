<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Load user model
require_once __DIR__ . "/../model/user.php";


// Check admin login
if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true ||
    !isset($_SESSION["role"]) ||
    strtolower(trim($_SESSION["role"])) !== "admin"
) {
    header("Location: /cms/view/common/login.php");
    exit();
}


$action = isset($_GET["action"])
    ? $_GET["action"]
    : "";


// Show users
if ($action === "users") {

    $_SESSION["users"] = getAllUsers();

    header(
        "Location: /cms/view/admin/user-management.php"
    );

    exit();
}


// Add user
if ($action === "addUser") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = isset($_POST["name"])
            ? trim($_POST["name"])
            : "";

        $email = isset($_POST["email"])
            ? trim($_POST["email"])
            : "";

        $role = isset($_POST["role"])
            ? trim($_POST["role"])
            : "";


        if (
            $name === "" ||
            $email === "" ||
            $role === ""
        ) {

            $_SESSION["userError"] =
                "All fields are required.";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $_SESSION["userError"] =
                "Invalid email address.";

        } else {

            if (addUserData($name, $email, $role)) {

                $_SESSION["userMessage"] =
                    "User added successfully.";

            } else {

                $_SESSION["userError"] =
                    "Failed to add user.";

            }
        }
    }


    header(
        "Location: /cms/controller/UserController.php?action=users"
    );

    exit();
}

?>