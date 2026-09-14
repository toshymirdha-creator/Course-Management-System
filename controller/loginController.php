<?php

session_start();

require_once __DIR__ . '/../model/user.php';


class LoginController
{
    public function login($email, $password)
    {
        $email = trim($email);
        $password = $password;


        // Validate email
        if (empty($email)) {
            return "Please fill up the email properly.";
        }


        // Validate password
        if (empty($password)) {
            return "Please fill up the password properly.";
        }


        // Check user from database
        $user = loginUser($email, $password);


        // Invalid login
        if ($user === false) {
            return "Invalid email or password.";
        }


        // Create login session
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userId'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];


        // Get role
        $role = strtolower(trim($user['role']));


        // Redirect according to role

        if ($role === "admin") {

            header("Location: /cms/view/admin/dashboard.php");
            exit();

        }


        if ($role === "teacher") {

            header("Location: /cms/view/teacher/teacherDashboard.php");
            exit();

        }


        if ($role === "student") {

            header("Location: /cms/view/student/dashboard.php");
            exit();

        }


        // Unknown role
        session_unset();
        session_destroy();

        return "Invalid user role.";
    }
}

?>