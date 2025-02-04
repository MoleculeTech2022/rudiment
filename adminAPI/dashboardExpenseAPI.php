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

// Fetch additional details from the database
$sql = "SELECT SUM(expense.expAmt) AS totalexpense , SUM(expense.expAmt) AS monthexpense
    FROM expense";
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


// Close the database connection
mysqli_close($conn);
?>