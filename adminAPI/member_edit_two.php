<?php
include 'dbcon.php';

// Check if mid, fname, and lname parameters are set
if(isset($_POST['mid']) && isset($_POST['fname']) && isset($_POST['lname'])) {
    // Retrieve mid, fname, and lname parameters
    $mid = $_POST['mid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    // SQL query to update student details by mid
    $sql = "UPDATE android SET fname = '$fname', lname = '$lname' WHERE mid = '$mid'";
    $result = mysqli_query($conn, $sql);

    // Check if query is successful
    if($result) {
        echo "Student details updated successfully";
    } else {
        echo "Error updating student details: " . mysqli_error($conn);
    }
} else {
    echo "Error : required parameters are not set";
}

mysqli_close($conn);
?>
