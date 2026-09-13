<?php

session_start();

require_once "user.php";

if (
    !isset($_SESSION["isLoggedIn"])
    || $_SESSION["isLoggedIn"] !== true
    || !isset($_SESSION["role"])
    || $_SESSION["role"] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action === "users") {
    $_SESSION["users"] = getAllUsers();
    header("Location: user-management.php");
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

    header("Location: UserController.php?action=users");
    exit();
}

?>