<?php 

session_start(); // Start the session to check if the user is logged in

// Check if the user is not logged in
if (!isset($_SESSION['student_email'])) {
    // Redirect to the login page
    header("Location: login_form.php");
    exit(); // Make sure to stop the script from further execution
}

?>