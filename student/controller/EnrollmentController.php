<?php

require_once __DIR__ . "/../model/Enrollment.php";

class EnrollmentController
{
    public function enroll($student_id, $course_id)
    {
        $enrollmentModel = new Enrollment();

        return $enrollmentModel->enrollStudent($student_id, $course_id);
    }

    public function myCourses($student_id)
    {
        $enrollmentModel = new Enrollment();

        return $enrollmentModel->getMyCourses($student_id);
    }

    public function unenroll($student_id, $course_id)
{
    $enrollmentModel = new Enrollment();

    return $enrollmentModel->unenrollStudent($student_id, $course_id);
}
}

?>