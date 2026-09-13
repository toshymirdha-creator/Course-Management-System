<?php session_start();

$_SESSION['fullnameErrMsg'] = "";
$_SESSION['lastnameErrMsg'] = "";
$_SESSION['emailErrMsg'] = "";
$_SESSION['passwordErrMsg'] = "";
$_SESSION['cpasswordErrMsg'] = "";
$_SESSION['globalErrMsg'] = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$fullname = htmlspecialchars($_POST['fullname']);
	$lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
	$password = ($_POST['password']);
    $cpassword = ($_POST['cpassword']);
	
	$flag = true;

    if (empty($fullname))
    {
		$flag = false;
		$_SESSION['fullnameErrMsg'] = "Please fill up Fullname properly";
	}
	else
    {
		$_SESSION['fullname'] = $fullname;
	}

	if (empty($lastname))
    {
		$flag = false;
		$_SESSION['lastnameErrMsg'] = "Please fill up Lastname properly";
	}
    else
    {
		$_SESSION['lastname'] = $lastname;
	}

	if (empty($email))
    {
		$flag = false;
		$_SESSION['emailErrMsg'] = "Please fill up Email properly";
	}
	else
    {
		$_SESSION['email'] = $email;
	}

	if (empty($password))
    {
		$flag = false;
		$_SESSION['passwordErrMsg'] = "Please fill up Password properly";
	}

    if (empty($cpassword))
    {
		$flag = false;
		$_SESSION['cpasswordErrMsg'] = "Please fill up Confirm Password properly";
	}
    else if ($password !== $cpassword)
    {
        $flag = false;
		$_SESSION['cpasswordErrMsg'] = "Password and Confirm Password do not match";
    }

    if($flag)
    {
        header("Location: ../view/login.php");
        exit();
    }
    else
    {
        header("Location: ../view/Registration.php"); 
        exit();
    }

}

else
{
    $_SESSION['globalErrMsg'] = "Something went wrong";
    header("Location: ../view/Registration.php"); 
    exit();
}

?>