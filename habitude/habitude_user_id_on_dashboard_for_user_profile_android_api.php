<?php
// Assuming you have a database connection
include "dbcon.php";
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "rudiment_db";

// $conn = mysqli_connect($host, $username, $password, $database);

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Check if sid is set in the request
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);

    // $sid = "1";
// ,mname,lname,classAdmitted,total_fees,SUM(payment.payamt) AS totalpaid 
    // Fetch additional details from the database
    $sql = "SELECT user_id,first_name,middle_name,last_name,user_roll,user_class FROM habitude_user
    WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Respond with JSON format
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Handle database query error
        echo "Error Database Queery: " . mysqli_error($con);
    }
} else {
    // Handle if username is not set in the request
    echo "Error: username parameter is missing";
}

// Close the database connection
mysqli_close($con);
?>