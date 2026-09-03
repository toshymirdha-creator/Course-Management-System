
<?php

session_start();

require_once '../../../controller/AdminController.php';

$admin = new AdminController();

$id = isset($_SESSION['id'])
    ? $_SESSION['id']
    : 1;

$user = $admin->profile($id);

?>

<!DOCTYPE html>
<html>

<head>

    <title>View Profile</title>

    <!-- Shared CSS -->
    <link rel="stylesheet" href="/cms/style.css">

</head>

<body>

    <h1>My Profile</h1>

    <hr>

    <p>

        Name:

        <?php

        echo isset($user['name'])
            ? htmlspecialchars($user['name'])
            : "Admin";

        ?>

    </p>

    <p>

        Email:

        <?php

        echo isset($user['email'])
            ? htmlspecialchars($user['email'])
            : "";

        ?>

    </p>

    <p>

        Role:

        <?php

        echo isset($user['role'])
            ? htmlspecialchars($user['role'])
            : "Admin";

        ?>

    </p>

    <hr>

    <?php

    if (isset($_COOKIE['userEmail'])) {

        echo "<p>Cookie Email: "
            . htmlspecialchars($_COOKIE['userEmail'])
            . "</p>";
    }

    ?>

    <br>

    <a href="edit-profile.php">
        Edit Profile
    </a>

    <br><br>

    <a href="../dashboard.php">
        Back to Dashboard
    </a>

</body>

</html>

