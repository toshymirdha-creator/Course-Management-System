<?php session_start();
if (!isset($_SESSION['isLoggedIn'])) {
	header("Location: login.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
        if (isset($_POST["load_students"])) {

        $course = $_POST["course"];
        $section = $_POST["section"];

        exit();
    }

}
?>
