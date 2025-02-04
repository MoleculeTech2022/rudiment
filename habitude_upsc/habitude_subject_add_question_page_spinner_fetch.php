<?php
header("Content-Type: application/json; charset=UTF-8");

// Include database connection
include 'dbcon.php';

// SQL query to fetch subjects from `habitude_subjects` table
$sql = "SELECT hab_subject FROM habitude_subjects";
$result = $conn->query($sql);

// Initialize an array to store subjects
$subjects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['hab_subject'];
    }
}

// Close database connection
$conn->close();

// Return subjects as a JSON response
echo json_encode($subjects);
?>
