<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>

    <link rel="stylesheet" href="/cms/style.css">
</head>

<body>

    <header>
        <nav>
            <h2>Course Management</h2>
            <h2>[LOGO]</h2>
        </nav>
    </header>

    <section class="page_header">
        <h1>RESET PASSWORD</h1>
    </section>

    <section>

        <form method="post"
              action="../controller/resetPasswordController.php">

            <label for="email">EMAIL :</label>

            <input type="email"
                   name="email"
                   id="email"
                   value="<?php echo isset($_SESSION['resetEmail']) ? $_SESSION['resetEmail'] : ''; ?>">

            <?php
            echo isset($_SESSION['emailErrMsg'])
                ? $_SESSION['emailErrMsg']
                : "";
            ?>

            <br><br>


            <label for="Npassword">NEW PASSWORD :</label>

            <input type="password"
                   name="newPassword"
                   id="Npassword">

            <?php
            echo isset($_SESSION['passwordErrMsg'])
                ? $_SESSION['passwordErrMsg']
                : "";
            ?>

            <br><br>


            <label for="Cpassword">CONFIRM PASSWORD :</label>

            <input type="password"
                   name="confirmPassword"
                   id="Cpassword">

            <?php
            echo isset($_SESSION['cpasswordErrMsg'])
                ? $_SESSION['cpasswordErrMsg']
                : "";
            ?>

            <br><br>


            <button type="submit">Continue</button>

            <a href="login.php">
                <button type="button">Cancel</button>
            </a>

            <?php
            echo isset($_SESSION['globalErrMsg'])
                ? $_SESSION['globalErrMsg']
                : "";
            ?>

        </form>

    </section>

</body>

</html>