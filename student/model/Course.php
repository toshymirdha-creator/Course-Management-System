<?php

require_once __DIR__ . "/../../model/dbConnect.php";

class Course
{
    public function getAllCourses()
    {
        global $conn;

        $sql = "SELECT * FROM courses";

        $result = mysqli_query($conn, $sql);

        return $result;
    }
}

?>