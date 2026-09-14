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

if ($action === "editProfile") {
    $userId = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

    if ($userId > 0) {
        $_SESSION["profile"] = getUserById($userId);
    }

    header("Location: profile/edit-profile.php");
    exit();
}

if ($action === "updateName") {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = trim($_POST["name"]);
        $userId = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

        if ($name === "") {
            $_SESSION["profileError"] = "Name is required.";
        } elseif ($userId <= 0) {
            $_SESSION["profileError"] = "User not found.";
        } elseif (updateUserName($userId, $name)) {
            $_SESSION["name"] = $name;
            $_SESSION["profileMessage"] = "Name updated successfully.";
        } else {
            $_SESSION["profileError"] = "Failed to update name.";
        }
    }

    header("Location: EditProfileController.php?action=editProfile");
    exit();
}

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
    $userId = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

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