<?php

session_start();

require_once __DIR__ . '/../model/ResetPassword.php';

$_SESSION['emailErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['cpasswordErrMsg'] = "";
$_SESSION['globalErrMsg'] = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $email = htmlspecialchars($_POST['email']);
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $flag = true;

    if (empty($email)) {
        $flag = false;
        $_SESSION['emailErrMsg'] = "Please fill up Email properly";
    }
    else {
        $_SESSION['resetEmail'] = $email;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $flag = false;
            $_SESSION['emailErrMsg'] = "Please enter a valid email";
        }
        else if (!resetEmailExists($email)) {
            $flag = false;
            $_SESSION['emailErrMsg'] = "Email is not registered";
        }
    }

    if (empty($newPassword)) {
        $flag = false;
        $_SESSION['passwordErrMsg'] = "Please fill up New Password properly";
    }

    if (empty($confirmPassword)) {
        $flag = false;
        $_SESSION['cpasswordErrMsg'] = "Please fill up Confirm Password properly";
    }
    else if ($newPassword !== $confirmPassword) {
        $flag = false;
        $_SESSION['cpasswordErrMsg'] = "Password and Confirm Password do not match";
    }

    if ($flag) {

        $result = updatePassword($email, $newPassword);

        if ($result) {

            unset($_SESSION['resetEmail']);

            $_SESSION['resetSuccess'] = "Password reset successful. Please login.";

            header("Location: ../view/login.php");
            exit();

        }
        else {

            $_SESSION['globalErrMsg'] = "Password reset failed. Please try again.";

            header("Location: ../view/resetPassword.php");
            exit();
        }

    }
    else {

        header("Location: ../view/resetPassword.php");
        exit();
    }

}
else {

    $_SESSION['globalErrMsg'] = "Something went wrong";

    header("Location: ../view/resetPassword.php");
    exit();
}

?>