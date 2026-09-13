<?php
session_start();

$user = isset($_SESSION["profile"]) ? $_SESSION["profile"] : array();

$message = isset($_SESSION["profileMessage"]) ? $_SESSION["profileMessage"] : "";
$error = isset($_SESSION["profileError"]) ? $_SESSION["profileError"] : "";

unset($_SESSION["profileMessage"]);
unset($_SESSION["profileError"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/cms/style.css">
</head>

<body>

<h2>Edit Profile</h2>

<?php
if ($message != "") {
    echo "<p>" . $message . "</p>";
}

if ($error != "") {
    echo "<p>" . $error . "</p>";
}
?>

<?php
if (!empty($user)) {
?>

<h3>Update Name</h3>

<form method="post"
      action="../EditProfileController.php?action=updateName">

    <label>Name:</label>

    <input type="text"
           name="name"
           id="name"
           value="<?php echo $user["name"]; ?>">

    <input type="submit" value="Update Name">

</form>

<br>

<h3>Update Email</h3>

<form id="emailForm">

    <label>Email:</label>

    <input type="text"
           name="email"
           id="email"
           value="<?php echo $user["email"]; ?>">

    <input type="submit" value="Update Email">

</form>

<p id="emailMessage"></p>

<script>
document.getElementById("emailForm").addEventListener("submit", function(event) {

    event.preventDefault();

    const email = document.getElementById("email").value;

    const formData = new FormData();
    formData.append("email", email);

    fetch("../EditProfileController.php?action=updateEmail", {
        method: "POST",
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        document.getElementById("emailMessage").innerHTML = data.message;
    });

});
</script>

<?php
} else {
    echo "<p>Profile information not found.</p>";
}
?>

<br>

<a href="../ViewProfileController.php">
    View Profile
</a>
<br><br>

<a href="../UserController.php?action=users">
    User Management
</a>

<br><br>

<a href="../CourseController.php?action=courses">
    Course Management
</a>

<br><br>

<a href="../CourseDropController.php?action=courseDrops">
    Course Drop Approval
</a>

</body>
</html>
