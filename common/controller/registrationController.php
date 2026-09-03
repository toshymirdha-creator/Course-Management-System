<?php

session_start();

require_once __DIR__ . '/../model/Registration.php';

$_SESSION['fullnameErrMsg'] = "";
$_SESSION['lastnameErrMsg'] = "";
$_SESSION['emailErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['cpasswordErrMsg'] = "";
$_SESSION['roleErrMsg'] = "";
$_SESSION['globalErrMsg'] = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $fullname = htmlspecialchars($_POST['fullname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = $_POST['role'];

    $flag = true;

    if (empty($fullname)) {
        $flag = false;
        $_SESSION['fullnameErrMsg'] = "Please fill up First Name properly";
    } else {
        $_SESSION['fullname'] = $fullname;
    }

    if (empty($lastname)) {
        $flag = false;
        $_SESSION['lastnameErrMsg'] = "Please fill up Last Name properly";
    } else {
        $_SESSION['lastname'] = $lastname;
    }

    if (empty($email)) {
        $flag = false;
        $_SESSION['emailErrMsg'] = "Please fill up Email properly";
    } else {
        $_SESSION['email'] = $email;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $flag = false;
            $_SESSION['emailErrMsg'] = "Please enter a valid email";
        }
        else if (emailExists($email)) {
            $flag = false;
            $_SESSION['emailErrMsg'] = "This email is already registered";
        }
    }

    if (empty($password)) {
        $flag = false;
        $_SESSION['passwordErrMsg'] = "Please fill up Password properly";
    }

    if (empty($cpassword)) {
        $flag = false;
        $_SESSION['cpasswordErrMsg'] = "Please fill up Confirm Password properly";
    }
    else if ($password !== $cpassword) {
        $flag = false;
        $_SESSION['cpasswordErrMsg'] = "Password and Confirm Password do not match";
    }

    if (empty($role)) {
        $flag = false;
        $_SESSION['roleErrMsg'] = "Please select a role";
    }

    if ($flag) {

        $name = $fullname . " " . $lastname;

        $result = registerUser($name, $email, $password, $role);

        if ($result) {

            $_SESSION['registrationSuccess'] = "Registration successful. Please login.";

            unset($_SESSION['fullname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['email']);

            header("Location: ../view/login.php");
            exit();

        } else {

            $_SESSION['globalErrMsg'] = "Registration failed. Please try again.";

            header("Location: ../view/Registration.php");
            exit();
        }

    } else {

        header("Location: ../view/Registration.php");
        exit();
    }

}
else {

    $_SESSION['globalErrMsg'] = "Something went wrong";

    header("Location: ../view/Registration.php");
    exit();
}

?>