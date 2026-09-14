
<?php

session_start();

if (
    !isset($_SESSION["isLoggedIn"]) ||
    $_SESSION["isLoggedIn"] !== true
) {
    header("Location: /cms/view/common/login.php");
    exit();
}

$name = isset($_SESSION["name"])
    ? $_SESSION["name"]
    : "";

$email = isset($_SESSION["email"])
    ? $_SESSION["email"]
    : "";

$role = isset($_SESSION["role"])
    ? $_SESSION["role"]
    : "";

$message = isset($_SESSION["profileMessage"])
    ? $_SESSION["profileMessage"]
    : "";

$error = isset($_SESSION["profileError"])
    ? $_SESSION["profileError"]
    : "";

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

    echo "<p>" . htmlspecialchars($message) . "</p>";

}


if ($error != "") {

    echo "<p>" . htmlspecialchars($error) . "</p>";

}

?>


<h3>Update Name</h3>


<form
    method="post"
    action="/cms/controller/EditProfileController.php?action=updateName"
>

    <label>Name:</label>

    <input
        type="text"
        name="name"
        id="name"
        value="<?php echo htmlspecialchars($name); ?>"
    >

    <input
        type="submit"
        value="Update Name"
    >

</form>


<br>


<h3>Update Email</h3>


<form
    id="emailForm"
>

    <label>Email:</label>

    <input
        type="text"
        name="email"
        id="email"
        value="<?php echo htmlspecialchars($email); ?>"
    >

    <input
        type="submit"
        value="Update Email"
    >

</form>


<p id="emailMessage"></p>


<script>

document.getElementById("emailForm").addEventListener(
    "submit",
    function(event) {

        event.preventDefault();

        const email =
            document.getElementById("email").value;

        const formData = new FormData();

        formData.append("email", email);

        fetch(
            "/cms/controller/EditProfileController.php?action=updateEmail",
            {
                method: "POST",
                body: formData
            }
        )
        .then(function(response) {

            return response.json();

        })
        .then(function(data) {

            document.getElementById(
                "emailMessage"
            ).innerHTML = data.message;

        });

    }
);

</script>


<br>


<a href="/cms/view/common/view-profile.php">
    View Profile
</a>


<br><br>


<a href="/cms/controller/UserController.php?action=users">
    User Management
</a>


<br><br>


<a href="/cms/controller/CourseController.php?action=courses">
    Course Management
</a>


<br><br>


<a href="/cms/controller/CourseDropController.php?action=courseDrops">
    Course Drop Approval
</a>


<br><br>


<a href="/cms/view/admin/dashboard.php">
    Back to Admin Dashboard
</a>


</body>

</html>

