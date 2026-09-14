<?php

require_once __DIR__ . "/../../controller/loginController.php";

$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = isset($_POST["email"])
        ? trim($_POST["email"])
        : "";

    $password = isset($_POST["password"])
        ? $_POST["password"]
        : "";


    $loginController = new LoginController();

    $message = $loginController->login($email, $password);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Course Management System Login</title>

</head>

<body>

    <h2>Course Management System Login</h2>

    <p>Please login with your student account.</p>


    <form method="POST" action="">

        <label for="email">Email:</label>

        <br>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <br><br>


        <label for="password">Password:</label>

        <br>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>


        <button type="submit">
            Login
        </button>

    </form>


    <?php if (!empty($message)) { ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>

</body>

</html>