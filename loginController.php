<?php 

session_start();

require '../model/User.php';

$_SESSION['emailErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['globalErrMsg'] = "";
$_SESSION['email'] = "";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$flag = true;

	if (empty($email)) {
		$flag = false;
		$_SESSION['emailErrMsg'] = "Please fill up the email properly";
	}
	else {
		$_SESSION['email'] = $email;
	}
	if (empty($password)) {
		$flag = false;
		$_SESSION['passwordErrMsg'] = "Please fill up the password properly";
	}
	if ($flag) {
		$isValid = register($email, $password);
		echo "Registration succesful";
	}
	else {
		echo "Please check again.";
	}	
}
else {
	$_SESSION['globalErrMsg'] = "Something went wrong.";
	header("Location: ../view/login.php");
	exit();
}

?>