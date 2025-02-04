<?php
// Database connection settings
require "dbcon.php";
// Get user input from the client-side
$input = $_GET['input'];

// Query the database for suggestions
$query = "SELECT DISTINCT fname, mname, lname FROM students WHERE fname LIKE '%$input%' OR mname LIKE '%$input%' OR lname LIKE '%$input%' LIMIT 10";
$result = $con->query($query);

// Fetch and return suggestions
$suggestions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row;
    }
}

echo json_encode($suggestions);

// Close the database connection
$con->close();
?>
