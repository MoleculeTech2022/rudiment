<?php
include('db.php');
// include('includes/login_check.php');

// Handling form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['student_fname']);
    $lname = $conn->real_escape_string($_POST['student_lname']);
    $email = $conn->real_escape_string($_POST['student_email']);
    $phone = $conn->real_escape_string($_POST['student_phone']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $password = password_hash($conn->real_escape_string($_POST['hab_student_password']), PASSWORD_BCRYPT); // Encrypt password

    // SQL query to insert data
    $sql = "INSERT INTO hab_students (student_fname, student_lname, student_email, student_phone, dob, hab_student_password) 
            VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page
        header("Location: login_form.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
