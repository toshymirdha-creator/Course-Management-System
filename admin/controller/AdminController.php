
<?php

require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/course.php';
require_once __DIR__ . '/../model/courseDrop.php';


class AdminController
{

    public function users()
    {
        return getAllUsers();
    }


    public function addUser($name, $email, $role)
    {
        return addUserData($name, $email, $role);
    }


    public function courses()
    {
        return getAllCourses();
    }


    public function addCourse($code, $name, $teacher)
    {
        return addCourseData($code, $name, $teacher);
    }


    public function deleteCourse($id)
    {
        return deleteCourseById($id);
    }


    public function courseDrops()
    {
        return getAllCourseDrops();
    }


    public function approveCourseDrop($id)
    {
        return approveCourseDropById($id);
    }


    public function rejectCourseDrop($id)
    {
        return rejectCourseDropById($id);
    }


    public function profile($id)
    {
        return getUserById($id);
    }


    public function updateEmail($id, $email)
    {
        return updateUserEmail($id, $email);
    }

}

?>
