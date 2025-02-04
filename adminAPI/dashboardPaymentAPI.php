<?php
// Assuming you have a database connection

include 'dbcon.php';

// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "rudiment_db";

// $conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT default_acdyear FROM default_acdyear";
$run = mysqli_query($conn, $query);

if ($run && $rows = mysqli_fetch_assoc($run)) {
    $default_acdyear = $rows['default_acdyear'];


// Fetch additional details from the database
$sql = "SELECT SUM(payment.payamt) AS paidfees , SUM(acdyear.total_fees) AS totalfees
    FROM payment
    JOIN acdyear ON acdyear.sid = payment.sid WHERE payment.acdyear = '$default_acdyear' AND acdyear.acdyear = '$default_acdyear'";
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
    echo "Error or no data found";
}


// Close the database connection
mysqli_close($conn);
?>