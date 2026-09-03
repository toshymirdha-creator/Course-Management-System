
<?php

session_start();

require_once __DIR__ . '/../../../controller/AdminController.php';

if (
    !isset($_SESSION['isLoggedIn'])
    || $_SESSION['isLoggedIn'] !== true
    || !isset($_SESSION['role'])
    || $_SESSION['role'] !== "Admin"
) {
    header("Location: /common/login.php");
    exit();
}

$admin = new AdminController();

$id = $_SESSION['id'];

$user = $admin->profile($id);

$name = "";
$email = "";
$role = "";

if (!empty($user)) {
    $name = $user['name'];
    $email = $user['email'];
    $role = $user['role'];
}




if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['emailUpdate'])
) {

    header("Content-Type: application/json");

    $newEmail = isset($_POST['email'])
        ? trim($_POST['email'])
        : "";

    if ($newEmail === "") {

        echo json_encode(array(
            "success" => false,
            "message" => "Please enter an email"
        ));

        exit();
    }

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {

        echo json_encode(array(
            "success" => false,
            "message" => "Please enter a valid email"
        ));

        exit();
    }

    $result = $admin->updateEmail(
        $id,
        $newEmail
    );

    if ($result) {

        $_SESSION['email'] = $newEmail;

        echo json_encode(array(
            "success" => true,
            "message" => "Email updated successfully"
        ));

    }
    else {

        echo json_encode(array(
            "success" => false,
            "message" => "Email update failed"
        ));

    }

    exit();
}




$nameErrMsg = "";
$globalErrMsg = "";

if (
    $_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['nameUpdate'])
) {

    $newName = isset($_POST['name'])
        ? trim($_POST['name'])
        : "";

    if ($newName === "") {

        $nameErrMsg = "Please enter your name";

    }
    else {

        $_SESSION['name'] = $newName;

        $name = $newName;

        $globalErrMsg = "Name updated successfully";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Profile</title>

    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>Edit Profile</h1>

    <hr>

    <?php

    if ($globalErrMsg != "") {

        echo "<p>"
            . htmlspecialchars($globalErrMsg)
            . "</p>";
    }

    ?>

    

    <h2>Update Name</h2>

    <form
        method="post"
        action="edit-profile.php"
        onsubmit="return validateProfileForm(this)"
        novalidate
    >

        <label for="name">Name:</label>

        <input
            type="text"
            id="name"
            name="name"
            value="<?php echo htmlspecialchars($name); ?>"
        >

        <br>

        <?php
        echo htmlspecialchars($nameErrMsg);
        ?>

        <br><br>

        <input
            type="submit"
            name="nameUpdate"
            value="Update Name"
        >

    </form>


    <hr>


    

    <h2>Update Email</h2>

    <form id="emailForm">

        <label for="email">Email:</label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?php echo htmlspecialchars($email); ?>"
        >

        <br><br>

        <input
            type="submit"
            value="Update Email"
        >

    </form>

    <p id="emailMessage"></p>


    <hr>

    <p>
        Role:
        <?php echo htmlspecialchars($role); ?>
    </p>

    <br>

    <a href="view-profile.php">View Profile</a>

    <br><br>

    <a href="../dashboard.php">Back to Dashboard</a>


    

    <script src="/cms/js/form-validation.js"></script>


    

    <script>

    document
        .getElementById("emailForm")
        .addEventListener(
            "submit",
            function(event) {

                event.preventDefault();

                const email =
                    document.getElementById("email").value.trim();

                const message =
                    document.getElementById("emailMessage");


                if (email === "") {

                    message.innerHTML =
                        "Please enter an email";

                    return;
                }


                if (!email.includes("@")) {

                    message.innerHTML =
                        "Please enter a valid email";

                    return;
                }


                const xhr =
                    new XMLHttpRequest();


                xhr.open(
                    "POST",
                    "edit-profile.php",
                    true
                );


                xhr.setRequestHeader(
                    "Content-Type",
                    "application/x-www-form-urlencoded"
                );


                xhr.onload = function() {

                    if (xhr.status === 200) {

                        try {

                            const response =
                                JSON.parse(
                                    xhr.responseText
                                );


                            message.innerHTML =
                                response.message;


                            if (response.success) {

                                document
                                    .getElementById("emailForm")
                                    .reset();

                                document
                                    .getElementById("email")
                                    .value = email;
                            }

                        }
                        catch (error) {

                            message.innerHTML =
                                "Server response error";

                        }

                    }
                    else {

                        message.innerHTML =
                            "Email update failed";
                    }

                };


                xhr.send(
                    "email="
                    + encodeURIComponent(email)
                    + "&emailUpdate=1"
                );

            }
        );

    </script>

</body>

</html>

