<?php

// database connection
include "../dbcon.php";

// Retrieve data from POST request
$sid = mysqli_real_escape_string($conn, $_POST['sid']);
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$mname = mysqli_real_escape_string($conn, $_POST['mname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$current_class = mysqli_real_escape_string($conn, $_POST['current_class']);
$mcontact = mysqli_real_escape_string($conn, $_POST['mcontact']);
$fcontact = mysqli_real_escape_string($conn, $_POST['fcontact']);

// SQL query to update student data
$sql_student = "UPDATE students
                SET fname = '$fname', 
                    mname = '$mname', 
                    lname = '$lname', 
                    current_class = '$current_class'
                WHERE sid = '$sid'";

// SQL query to update parent data
$sql_parent = "UPDATE parents
               SET mcontact = '$mcontact', 
                   fcontact = '$fcontact' 
               WHERE sid = '$sid'";

// Execute queries
$sql_query_run_student = mysqli_query($conn, $sql_student);
$sql_query_run_parent = mysqli_query($conn, $sql_parent);

if (mysqli_affected_rows($conn) > 0) {
    echo "Data updated successfully";
} else {
    echo "No records updated for the provided ID";
}

// Close connection
mysqli_close($conn);
?>
