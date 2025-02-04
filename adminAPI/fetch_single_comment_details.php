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
if (isset($_GET['follow_id'])) {
    $follow_id = mysqli_real_escape_string($conn, $_GET['follow_id']);

    // $sid = "1";
// ,mname,lname,classAdmitted,total_fees,SUM(payment.payamt) AS totalpaid 
    // Fetch additional details from the database
    $sql = "SELECT dof,followby,followmode,comment,nextstep
    FROM followup
    WHERE follow_id = '$follow_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Respond with JSON format
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Handle database query error
        echo "Error Database Queery: " . mysqli_error($conn);
    }
} else {
    // Handle if sid is not set in the request
    echo "Error: Follow ID parameter is missing";
}

// Close the database connection
mysqli_close($conn);
?>