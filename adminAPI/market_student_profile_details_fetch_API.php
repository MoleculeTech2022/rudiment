<?php

include "dbcon.php";

// Assuming you have a database connection
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "marketing";

// $conn = mysqli_connect($host, $username, $password, $database);

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Check if sid is set in the request
if (isset($_GET['sid'])) {
    $sid = mysqli_real_escape_string($conn, $_GET['sid']);

    // $sid = "1";

    // Fetch additional details from the database
    $sql = "SELECT fname,mname,lname,forclass,faname,moname,fcontact,mcontact,school,region,`address` 
    FROM normal_list
    WHERE normal_list.sid = '$sid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Respond with JSON format
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Handle database query error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle if sid is not set in the request
    echo "Error: sid parameter is missing";
}

// Close the database connection
mysqli_close($conn);
?>