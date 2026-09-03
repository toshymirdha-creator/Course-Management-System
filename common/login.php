
<?php

session_start();

require_once __DIR__ . '/../model/dbConnect.php';

$emailErrMsg = "";
$passwordErrMsg = "";
$globalErrMsg = "";

$email = "";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

    $email = isset($_POST['email'])
        ? trim($_POST['email'])
        : "";

    $password = isset($_POST['password'])
        ? trim($_POST['password'])
        : "";

    $flag = true;


    if (empty($email))
    {
        $flag = false;
        $emailErrMsg = "Please fill up the email properly";
    }


    if (empty($password))
    {
        $flag = false;
        $passwordErrMsg = "Please fill up the password properly";
    }


    if ($flag)
    {

        $sql = "SELECT id, name, email, password, role
                FROM users
                WHERE email = '$email'
                AND password = '$password'";

        $result = mysqli_query($conn, $sql);


        if (!$result)
        {

            $globalErrMsg = "Database error: " . mysqli_error($conn);

        }
        elseif (mysqli_num_rows($result) == 1)
        {

            $user = mysqli_fetch_assoc($result);


            $_SESSION['isLoggedIn'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];


            // Make role format consistent

            $role = trim($user['role']);
            $role = ucfirst(strtolower($role));

            $_SESSION['role'] = $role;


            // Cookie

            setcookie(
                "userEmail",
                $user['email'],
                time() + 3600,
                "/"
            );


            // Admin

            if ($role === "Admin")
            {

                header("Location: /cms/admin/view/admin/dashboard.php");
                exit();

            }


            // Student

            elseif ($role === "Student")
            {

                header("Location: /cms/student/view/dashboard.php");
                exit();

            }


            // Teacher

            elseif ($role === "Teacher")
            {

                header("Location: /cms/teacher/view/teacherDashboard.php");
                exit();

            }


            else
            {

                $globalErrMsg = "Invalid user role";

            }

        }
        else
        {

            $globalErrMsg = "Invalid email or password";

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Login</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>


<body>


    <h1>Login</h1>

    <hr>


    <?php

    if ($globalErrMsg != "")
    {
        echo "<p>" . htmlspecialchars($globalErrMsg) . "</p>";
    }

    ?>


    <form
        method="post"
        action="login.php"
        onsubmit="return validateLoginForm(this)"
        novalidate
    >


        <label for="email">
            Email:
        </label>


        <input
            type="text"
            name="email"
            id="email"
            value="<?php echo htmlspecialchars($email); ?>"
        >


        <p>
            <?php echo htmlspecialchars($emailErrMsg); ?>
        </p>


        <label for="password">
            Password:
        </label>


        <input
            type="password"
            name="password"
            id="password"
        >


        <p>
            <?php echo htmlspecialchars($passwordErrMsg); ?>
        </p>


        <input
            type="submit"
            value="Login"
        >


    </form>


    <script src="/cms/js/form-validation.js"></script>


</body>

</html>

