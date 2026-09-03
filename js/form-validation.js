function validateUserForm(pForm) {

    const name = pForm.name.value.trim();
    const email = pForm.email.value.trim();
    const role = pForm.role.value;

    if (name === "") {

        alert("Please fill up the name properly");

        return false;
    }

    if (email === "") {

        alert("Please fill up the email properly");

        return false;
    }

    if (!email.includes("@")) {

        alert("Please enter a valid email");

        return false;
    }

    if (role === "") {

        alert("Please select a role");

        return false;
    }

    return true;
}


function validateCourseForm(pForm) {

    const code = pForm.code.value.trim();
    const name = pForm.name.value.trim();
    const teacher = pForm.teacher.value.trim();

    if (code === "") {

        alert("Please fill up the course code properly");

        return false;
    }

    if (name === "") {

        alert("Please fill up the course name properly");

        return false;
    }

    if (teacher === "") {

        alert("Please fill up the teacher name properly");

        return false;
    }

    return true;
}


function validateProfileForm(pForm) {

    const name = pForm.name.value.trim();

    if (name === "") {

        alert("Please fill up the name properly");

        return false;
    }

    return true;
}


function validateLoginForm(pForm) {

    const email = pForm.email.value.trim();

    const password = pForm.password.value;

    if (email === "") {

        alert("Please fill up the email properly");

        return false;
    }

    if (password === "") {

        alert("Please fill up the password properly");

        return false;
    }

    return true;
}


function validateCourseEnrollment(form) {

    const course = form.course.value;

    if (course === "") {

        alert("Please select a course");

        return false;
    }

    return true;
}


function validateCourseDropRequest(form) {

    const course = form.course.value;

    const reason = form.reason.value.trim();

    if (course === "") {

        alert("Please select a course");

        return false;
    }

    if (reason === "") {

        alert("Please enter a reason");

        return false;
    }

    return true;
    function validateRegistrationForm(form) {

    const fullname = form.fullname.value.trim();
    const lastname = form.lastname.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const cpassword = form.cpassword.value;
    const role = form.role.value;

    if (fullname === "") {
        alert("Please fill up First Name properly");
        return false;
    }

    if (lastname === "") {
        alert("Please fill up Last Name properly");
        return false;
    }

    if (email === "") {
        alert("Please fill up Email properly");
        return false;
    }

    if (!email.includes("@")) {
        alert("Please enter a valid email");
        return false;
    }

    if (password === "") {
        alert("Please fill up Password properly");
        return false;
    }

    if (cpassword === "") {
        alert("Please fill up Confirm Password properly");
        return false;
    }

    if (password !== cpassword) {
        alert("Password and Confirm Password do not match");
        return false;
    }

    if (role === "") {
        alert("Please select a role");
        return false;
    }

    return true;
}
}