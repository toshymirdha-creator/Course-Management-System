
<?php

session_start();

require_once __DIR__ . "/../model/dbConnect.php";


$_SESSION['fullnameErrMsg'] = "";
$_SESSION['lastnameErrMsg'] = "";
$_SESSION['emailErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['cpasswordErrMsg'] = "";
$_SESSION['globalErrMsg'] = "";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $fullname = isset($_POST['fullname'])
        ? trim($_POST['fullname'])
        : "";

    $lastname = isset($_POST['lastname'])
        ? trim($_POST['lastname'])
        : "";

    $email = isset($_POST['email'])
        ? trim($_POST['email'])
        : "";

    $password = isset($_POST['password'])
        ? $_POST['password']
        : "";

    $cpassword = isset($_POST['cpassword'])
        ? $_POST['cpassword']
        : "";


    $flag = true;


    if (empty($fullname)) {

        $flag = false;

        $_SESSION['fullnameErrMsg'] =
            "Please fill up Fullname properly";

    } else {

        $_SESSION['fullname'] = $fullname;
    }


    if (empty($lastname)) {

        $flag = false;

        $_SESSION['lastnameErrMsg'] =
            "Please fill up Lastname properly";

    } else {

        $_SESSION['lastname'] = $lastname;
    }


    if (empty($email)) {

        $flag = false;

        $_SESSION['emailErrMsg'] =
            "Please fill up Email properly";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $flag = false;

        $_SESSION['emailErrMsg'] =
            "Please enter a valid email";

    } else {

        $_SESSION['email'] = $email;
    }


    if (empty($password)) {

        $flag = false;

        $_SESSION['passwordErrMsg'] =
            "Please fill up Password properly";
    }


    if (empty($cpassword)) {

        $flag = false;

        $_SESSION['cpasswordErrMsg'] =
            "Please fill up Confirm Password properly";

    } elseif ($password !== $cpassword) {

        $flag = false;

        $_SESSION['cpasswordErrMsg'] =
            "Password and Confirm Password do not match";
    }


    if ($flag) {

        /*
         * Combine first name and last name
         */

        $name = $fullname . " " . $lastname;


        /*
         * Check whether email already exists
         */

        $email = mysqli_real_escape_string(
            $conn,
            $email
        );

        $checkSql = "
            SELECT id
            FROM users
            WHERE email = '$email'
        ";

        $checkResult = mysqli_query(
            $conn,
            $checkSql
        );


        if (
            $checkResult &&
            mysqli_num_rows($checkResult) > 0
        ) {

            $_SESSION['emailErrMsg'] =
                "This email is already registered";

            header(
                "Location: /cms/view/common/registration.php"
            );

            exit();
        }


        /*
         * Prepare data for database
         */

        $name = mysqli_real_escape_string(
            $conn,
            $name
        );

        $password = mysqli_real_escape_string(
            $conn,
            $password
        );


        /*
         * New registration will be Student
         */

        $role = "student";


        /*
         * Save user
         */

        $sql = "
            INSERT INTO users
            (name, email, password, role)
            VALUES
            ('$name', '$email', '$password', '$role')
        ";


        $result = mysqli_query(
            $conn,
            $sql
        );


        if ($result) {

            unset($_SESSION['fullname']);
            unset($_SESSION['lastname']);
            unset($_SESSION['email']);

            unset($_SESSION['fullnameErrMsg']);
            unset($_SESSION['lastnameErrMsg']);
            unset($_SESSION['emailErrMsg']);
            unset($_SESSION['passwordErrMsg']);
            unset($_SESSION['cpasswordErrMsg']);
            unset($_SESSION['globalErrMsg']);


            /*
             * Registration successful
             * Go to Login
             */

            header(
                "Location: /cms/view/common/login.php"
            );

            exit();

        } else {

            $_SESSION['globalErrMsg'] =
                "Registration failed";

            header(
                "Location: /cms/view/common/registration.php"
            );

            exit();
        }

    } else {

        /*
         * Validation failed
         */

        header(
            "Location: /cms/view/common/registration.php"
        );

        exit();
    }

}


$_SESSION['globalErrMsg'] =
    "Something went wrong";

header(
    "Location: /cms/view/common/registration.php"
);

exit();

?>

