<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Page</title>
</head>
<body>

	<?php include 'Header.php'; ?>

	<form method="post" action="../controller/LoginController.php" onsubmit="return validate(this)" novalidate>
		<label for="email">Email</label>
		<input type="email" name="email" id="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : "" ?>">

		<?php echo isset($_SESSION['emailErrMsg']) ? $_SESSION['emailErrMsg'] : "" ?>
		<br><br>

		<label for="password">Password</label>
		<input type="password" name="password" id="password">

		<?php echo isset($_SESSION['passwordErrMsg']) ? $_SESSION['passwordErrMsg'] : "" ?>
		<br><br>

		<input type="checkbox" name="rememberMe" id="rememberMe">
		<label for="rememberMe">Remember Me</label>

		<br><br>

		<input type="submit" value="Login">
	</form>

	<span id="msg"></span>
	<span id="msg1"></span>

	<?php echo isset($_SESSION['globalErrMsg']) ? $_SESSION['globalErrMsg'] : "" ?>

	<script src="login.js"></script>

	<?php include 'Footer.php'; ?>

</body>
</html>