<?php
// Assuming you have a database connection
include "dbcon.php";

// Check if subject is set in the request
if (isset($_GET['chapter'])) {
    // Escape the input to prevent SQL injection
    $chapter = mysqli_real_escape_string($conn, $_GET['chapter']);

    // Construct the SQL query
    $sql = "SELECT note_id,subject,subtopic,date,note,chapter FROM i_upsc_notes WHERE chapter = '$chapter'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Initialize an empty array to store the rows
        $rows = array();

        // Fetch each row as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        // Check if any rows are found
        if (!empty($rows)) {
            // Respond with JSON format
            header('Content-Type: application/json');
            echo json_encode($rows);
        } else {
            // Respond with an error message if no rows are found
            echo json_encode(["error" => "No data found for the provided subject"]);
        }
    } else {
        // Handle database query error
        echo json_encode(["error" => "Database query error: " . mysqli_error($conn)]);
    }
} else {
    // Respond with an error message if subject parameter is missing
    echo json_encode(["error" => "Chapter parameter is missing"]);
}

// Close the database connection
mysqli_close($conn);
?>
