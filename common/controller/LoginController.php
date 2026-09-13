<?php

session_start();

require_once __DIR__ . "/../model/User.php";

class LoginController
{
    public function login($email, $password)
    {
        $userModel = new User();

        $user = $userModel->loginUser($email, $password);

        if ($user != false) {

            $_SESSION["user"] = $user;

            if ($user["role"] == "student") {

                header("Location: ../../student/view/dashboard.php");
                exit();

            } else {

                return "Only student login is available.";

            }

        } else {

            return "Invalid email or password!";

        }
    }
}

?>