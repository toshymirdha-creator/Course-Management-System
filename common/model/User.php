<?php

require_once __DIR__ . "/../../model/dbConnect.php";

class User
{
    public function loginUser($email, $password)
    {
        global $conn;

        $sql = "SELECT * FROM users 
                WHERE email = '$email' 
                AND password = '$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
}

?>