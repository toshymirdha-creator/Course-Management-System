<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Registration</title>

    <link rel="stylesheet" href="/cms/style.css">
    <script src="/cms/js/form-validation.js"></script>
</head>

<body>

    <header>
        <nav>
            <h2>Course Management</h2>
            <h2>[LOGO]</h2>
        </nav>
    </header>

    <section class="page_header">
        <h1>USER REGISTRATION</h1>
    </section>

    <section>

        <form method="post"
              action="../controller/registrationController.php"
              onsubmit="return validateRegistrationForm(this)"
              novalidate>

            <label for="fname">FIRST NAME :</label>

            <input type="text"
                   name="fullname"
                   id="fname"
                   value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>">

            <?php
            echo isset($_SESSION['fullnameErrMsg'])
                ? $_SESSION['fullnameErrMsg']
                : "";
            ?>

            <br><br>


            <label for="lname">LAST NAME :</label>

            <input type="text"
                   name="lastname"
                   id="lname"
                   value="<?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : ''; ?>">

            <?php
            echo isset($_SESSION['lastnameErrMsg'])
                ? $_SESSION['lastnameErrMsg']
                : "";
            ?>

            <br><br>


            <label for="email">EMAIL :</label>

            <input type="email"
                   name="email"
                   id="email"
                   value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">

            <?php
            echo isset($_SESSION['emailErrMsg'])
                ? $_SESSION['emailErrMsg']
                : "";
            ?>

            <br><br>


            <label for="password">PASSWORD :</label>

            <input type="password"
                   name="password"
                   id="password">

            <?php
            echo isset($_SESSION['passwordErrMsg'])
                ? $_SESSION['passwordErrMsg']
                : "";
            ?>

            <br><br>


            <label for="cpassword">CONFIRM PASSWORD :</label>

            <input type="password"
                   name="cpassword"
                   id="cpassword">

            <?php
            echo isset($_SESSION['cpasswordErrMsg'])
                ? $_SESSION['cpasswordErrMsg']
                : "";
            ?>

            <br><br>


            <label for="role">ROLE :</label>

            <select name="role" id="role">

                <option value="">Select Role</option>

                <option value="student">Student</option>

                <option value="teacher">Teacher</option>

            </select>

            <?php
            echo isset($_SESSION['roleErrMsg'])
                ? $_SESSION['roleErrMsg']
                : "";
            ?>

            <br><br>


            <button type="submit">REGISTER</button>

            <?php
            echo isset($_SESSION['globalErrMsg'])
                ? $_SESSION['globalErrMsg']
                : "";
            ?>


            <h3>
                Already Registered?
                <span>
                    <a href="login.php">Login</a>
                </span>
            </h3>

        </form>

    </section>

</body>

</html>