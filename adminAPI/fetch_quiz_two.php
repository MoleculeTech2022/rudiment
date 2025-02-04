<?php

// database connection
include 'dbcon.php';

// Fetch question ID from GET parameters
$questionId = $_GET['question_id'];

// Query to fetch details for the given question ID
$query = "SELECT question,answer, explanation FROM quiz WHERE question_id = $questionId";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Fetch result row
    $row = mysqli_fetch_assoc($result);

    // Return details as JSON
    echo json_encode($row);
} else {
    // Handle query failure
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);

?>
