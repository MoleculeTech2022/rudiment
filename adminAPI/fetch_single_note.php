<?php
// Assuming you have a database connection
include "dbcon.php";

// Check if note_id is set in the request
if (isset($_GET['note_id'])) {
    $note_id = mysqli_real_escape_string($conn, $_GET['note_id']);

    // Fetch details from the database based on note_id
    $sql = "SELECT note, date, subject, subtopic, chapter FROM i_upsc_notes WHERE note_id = '$note_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if any row is returned
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            // Respond with JSON format
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            // If no rows found
            echo json_encode(array("message" => "No details found for this note_id"));
        }
    } else {
        // Handle database query error
        echo "Error Database Query: " . mysqli_error($conn);
    }
} else {
    // Handle if note_id is not set in the request
    echo "Error: note_id parameter is missing";
}

// Close the database connection
mysqli_close($conn);
?>
