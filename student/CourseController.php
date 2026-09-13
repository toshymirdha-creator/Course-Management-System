<?php

require_once __DIR__ . "/Course.php";
class CourseController
{
    public function showCourses()
    {
        $courseModel = new Course();

        return $courseModel->getAllCourses();
    }
}

?>