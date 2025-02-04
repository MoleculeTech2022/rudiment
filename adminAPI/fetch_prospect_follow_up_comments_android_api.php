<?php
// Database connection

include "dbcon.php";

// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "rudiment_db";

// // Create connection
// $conn = mysqli_connect($host, $username, $password, $database);

// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Get sid from the request
$pros_id = isset($_GET['pros_id']) ? $_GET['pros_id'] : die('pros_id parameter is missing');

// Fetch payment details for the given sid
$query = "SELECT follow_id,dof , followby, followmode, comment,nextstep FROM followup WHERE pros_id = " . $pros_id;
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Create an array to store payment details
$payments = array();

// Fetch and store payment details in the array
while ($row = mysqli_fetch_assoc($result)) {
    $payments[] = $row;
}

// Close the connection
mysqli_close($conn);

// Return the payment details as JSON
header('Content-Type: application/json');
echo json_encode($payments);
?>