<?php
session_start();

$user = isset($_SESSION["profile"]) ? $_SESSION["profile"] : array();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <link rel="stylesheet" href="../../../../style.css">
</head>

<body>

<h2>My Profile</h2>

<?php
if (!empty($user)) {
?>

<p>
    <strong>Name:</strong>
    <?php echo $user["name"]; ?>
</p>

<p>
    <strong>Email:</strong>
    <?php echo $user["email"]; ?>
</p>

<p>
    <strong>Role:</strong>
    <?php echo $user["role"]; ?>
</p>

<?php
} else {
    echo "<p>Profile information not found.</p>";
}
?>

<br>

<a href="../../../controller/AdminController.php?action=users">
    User Management
</a>

<br><br>

<a href="../../../controller/AdminController.php?action=courses">
    Course Management
</a>

<br><br>

<a href="../../../controller/AdminController.php?action=courseDrops">
    Course Drop Approval
</a>

<br><br>

<a href="../../../controller/AdminController.php?action=editProfile">
    Edit Profile
</a>

</body>
</html>