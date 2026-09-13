<?php

require_once __DIR__ . "/../controller/LoginController.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $loginController = new LoginController();

    $message = $loginController->login($email, $password);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

    <h2>Course Management System Login</h2>
    <p>Please login with your student account.</p>

    <form method="POST">

        <label>Email:</label>
        <br>
        <input type="email" name="email" required>

        <br><br>

        <label>Password:</label>
        <br>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Login</button>

    </form>

    <p><?php echo $message; ?></p>

</body>

</html>