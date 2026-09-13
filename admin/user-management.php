<?php
session_start();

$users = isset($_SESSION["users"]) ? $_SESSION["users"] : array();

$message = isset($_SESSION["userMessage"]) ? $_SESSION["userMessage"] : "";
$error = isset($_SESSION["userError"]) ? $_SESSION["userError"] : "";

unset($_SESSION["userMessage"]);
unset($_SESSION["userError"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="/cms/style.css">
</head>

<body>

<h2>User Management</h2>

<?php
if ($message != "") {
    echo "<p>" . $message . "</p>";
}

if ($error != "") {
    echo "<p>" . $error . "</p>";
}
?>

<form method="post" action="AdminController.php?action=addUser">

    <label>Name:</label>
    <input type="text" name="name" id="name">
    <br><br>

    <label>Email:</label>
    <input type="text" name="email" id="email">
    <br><br>

    <label>Role:</label>
    <select name="role" id="role">
        <option value="">Select Role</option>
        <option value="Admin">Admin</option>
        <option value="Teacher">Teacher</option>
        <option value="Student">Student</option>
    </select>
    <br><br>

    <input type="submit" value="Add User">

</form>

<hr>

<h3>All Users</h3>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    <?php
    foreach ($users as $user) {
    ?>

    <tr>
        <td><?php echo $user["id"]; ?></td>
        <td><?php echo $user["name"]; ?></td>
        <td><?php echo $user["email"]; ?></td>
        <td><?php echo $user["role"]; ?></td>
    </tr>

    <?php
    }
    ?>

</table>

<br>

<a href="AdminController.php?action=courses">
    Course Management
</a>

<br><br>

<a href="AdminController.php?action=courseDrops">
    Course Drop Approval
</a>

<br><br>

<a href="AdminController.php?action=profile">
    View Profile
</a>

<br><br>

<a href="AdminController.php?action=editProfile">
    Edit Profile
</a>

</body>
</html>
