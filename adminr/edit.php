<!-- // This is a file to update student record  -->
<!--  It update 4 tables.. student, parent, acdyear, payment-->
<!--  Last Change - 06 April 2024-->

<?php
require 'dbcon.php';

// Check if form is submitted
if (isset($_POST['edit_btn'])) {

    // Sanitize and get the form data
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $mname = mysqli_real_escape_string($con, $_POST['mname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $classAdmitted = mysqli_real_escape_string($con, $_POST['classAdmitted']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $doa = mysqli_real_escape_string($con, $_POST['doa']); // Date Of Admission
    $saadhar = mysqli_real_escape_string($con, $_POST['saadhar']);
    $religion = mysqli_real_escape_string($con, $_POST['religion']);
    $caste = mysqli_real_escape_string($con, $_POST['caste']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $current_class = mysqli_real_escape_string($con, $_POST['current_class']);


    $faname = mysqli_real_escape_string($con, $_POST['faname']);
    $foccup = mysqli_real_escape_string($con, $_POST['foccup']);
    $fcontact = mysqli_real_escape_string($con, $_POST['fcontact']);
    $moname = mysqli_real_escape_string($con, $_POST['moname']);
    $moccup = mysqli_real_escape_string($con, $_POST['moccup']);
    $mcontact = mysqli_real_escape_string($con, $_POST['mcontact']);
    $padr = mysqli_real_escape_string($con, $_POST['padr']);
    $pdis = mysqli_real_escape_string($con, $_POST['pdis']);
    $local_addr = mysqli_real_escape_string($con, $_POST['local_addr']);
    $pstate = mysqli_real_escape_string($con, $_POST['pstate']);

    // Update students table
    $update_student_query = "UPDATE students SET fname='$fname', mname='$mname', lname='$lname', classAdmitted='$classAdmitted', current_class='$current_class', dob='$dob', doa='$doa', saadhar='$saadhar', religion='$religion', caste='$caste', category='$category', gender='$gender' WHERE sid='$student_id'";

    // Update parents table
    $update_parent_query = "UPDATE parents SET faname='$faname', foccup='$foccup', fcontact='$fcontact', moname='$moname', moccup='$moccup', mcontact='$mcontact', padr='$padr', pdis='$pdis', local_addr='$local_addr', pstate='$pstate' WHERE sid='$student_id'";

    // Execute queries
    $update_student = mysqli_query($con, $update_student_query);
    $update_parent = mysqli_query($con, $update_parent_query);

    if ($update_student && $update_parent) {
        // Redirect to success page or do whatever you want
        header("Location: student-view.php?sid=$student_id");
        exit();
    } else {
        // Handle error
        echo "Error updating record: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // Redirect if form is not submitted
    header("Location: index.php");
    exit();
}
?>