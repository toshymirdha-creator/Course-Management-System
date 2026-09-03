<?php

session_start();

require_once '../../controller/AdminController.php';

$nameErrMsg = "";
$emailErrMsg = "";
$roleErrMsg = "";
$globalErrMsg = "";

$name = "";
$email = "";
$role = "";

$admin = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $name = isset($_POST['name'])
        ? htmlspecialchars($_POST['name'])
        : "";

    $email = isset($_POST['email'])
        ? htmlspecialchars($_POST['email'])
        : "";

    $role = isset($_POST['role'])
        ? htmlspecialchars($_POST['role'])
        : "";

    $flag = true;

    if (empty($name)) {

        $flag = false;

        $nameErrMsg = "Please fill up the name properly";
    }

    if (empty($email)) {

        $flag = false;

        $emailErrMsg = "Please fill up the email properly";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $flag = false;

        $emailErrMsg = "Please enter a valid email";
    }

    if (empty($role)) {

        $flag = false;

        $roleErrMsg = "Please select a role";
    }

    if ($flag) {

        $admin->addUser($name, $email, $role);

        $globalErrMsg = "User added successfully";

        $name = "";
        $email = "";
        $role = "";
    }
    else {

        $globalErrMsg = "User add failed";
    }
}

$users = $admin->users();

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Management</title>

<link rel="stylesheet" href="/cms/style.css">
</head>

<body>

    <h1>User Management</h1>

    <hr>

    <?php

    if ($globalErrMsg != "") {

        echo "<p>" . htmlspecialchars($globalErrMsg) . "</p>";
    }

    ?>

    <form
        method="post"
        action="user-management.php"
        onsubmit="return validateUserForm(this)"
        novalidate
    >

        <label for="name">
            Name:
        </label>

        <input
            type="text"
            name="name"
            id="name"
            value="<?php echo htmlspecialchars($name); ?>"
        >

        <br>

        <p>
            <?php echo htmlspecialchars($nameErrMsg); ?>
        </p>

        <label for="email">
            Email:
        </label>

        <input
            type="email"
            name="email"
            id="email"
            value="<?php echo htmlspecialchars($email); ?>"
        >

        <br>

        <p>
            <?php echo htmlspecialchars($emailErrMsg); ?>
        </p>

        <label for="role">
            Role:
        </label>

        <select name="role" id="role">

            <option value="">Select Role</option>

            <option value="Student"
                <?php
                if ($role == "Student") {
                    echo "selected";
                }
                ?>
            >
                Student
            </option>

            <option value="Teacher"
                <?php
                if ($role == "Teacher") {
                    echo "selected";
                }
                ?>
            >
                Teacher
            </option>

            <option value="Admin"
                <?php
                if ($role == "Admin") {
                    echo "selected";
                }
                ?>
            >
                Admin
            </option>

        </select>

        <br>

        <p>
            <?php echo htmlspecialchars($roleErrMsg); ?>
        </p>

        <input
            type="submit"
            name="addUser"
            value="Add User"
        >

    </form>

    <br>

    <h3>Users</h3>

    <table border="1" cellpadding="10">

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>

        </tr>

        <?php

        foreach ($users as $user) {

            echo "<tr>";

            echo "<td>" . htmlspecialchars($user['id']) . "</td>";

            echo "<td>" . htmlspecialchars($user['name']) . "</td>";

            echo "<td>" . htmlspecialchars($user['email']) . "</td>";

            echo "<td>" . htmlspecialchars($user['role']) . "</td>";

            echo "</tr>";
        }

        ?>

    </table>

    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

<script src="/cms/js/form-validation.js"></script>
</body>

</html>