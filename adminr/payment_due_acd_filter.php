<?php
// Include your database connection file
include "dbcon.php";

// Check if the academic year and student ID are set
if (isset($_POST['academic_year']) && isset($_POST['sid'])) {
    // Sanitize the input data
    $academic_year = mysqli_real_escape_string($con, $_POST['academic_year']);
    $student_id = mysqli_real_escape_string($con, $_POST['sid']);

    // Your SQL query to fetch payment details based on academic year and student ID
    $query = "SELECT * FROM payment WHERE sid = '$student_id' AND acdyear = '$academic_year'";

    // Execute the query
    $result = mysqli_query($con, $query);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        // Loop through the results and display them
        while ($row = mysqli_fetch_assoc($result)) {
            // Here you can format and display each payment record as desired
            echo "Amount: " . $row['payamt'] . ", Mode: " . $row['paymode'] . ", Date: " . $row['paydate'];
        }
    } else {
        // If no results are found, display a message
        echo "No payment records found for the selected academic year.";
    }
} else {
    // If academic year or student ID is not set, display an error message
    echo "Error: Academic year or student ID not provided.";
}
?>