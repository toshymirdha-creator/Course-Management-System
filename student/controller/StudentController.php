
<?php

require_once __DIR__ . '/../model/Student.php';
require_once __DIR__ . '/../model/Course.php';
require_once __DIR__ . '/../model/CourseDrop.php';


class StudentController
{

    public function login($email, $password)
    {
        return loginStudent($email, $password);
    }


    public function profile($id)
    {
        return getStudentProfile($id);
    }


    public function courses()
    {
        return getAvailableCourses();
    }


    public function enroll($studentId, $courseId)
    {
        return enrollCourse($studentId, $courseId);
    }


    public function enrolledCourses($studentId)
    {
        return getEnrolledCourses($studentId);
    }


    public function materials()
    {
        return getMaterials();
    }


    public function submitDrop($studentId, $courseId, $reason)
    {
        return submitDropRequest($studentId, $courseId, $reason);
    }


    public function dropRequests($studentId)
    {
        return getStudentDropRequests($studentId);
    }

}

?>

