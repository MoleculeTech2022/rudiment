<?php
// Assuming you have a database connection
include "dbcon.php";

// Check if subject is set in the request
if (isset($_GET['subject'])) {
    // Escape the input to prevent SQL injection
    $subject = mysqli_real_escape_string($conn, $_GET['subject']);

    // Construct the SQL query
    //$sql = "SELECT DISTINCT chapter FROM i_upsc_notes WHERE subject = '$subject' ORDER BY chapter ASC";
        $sql = "SELECT DISTINCT chapter FROM i_upsc_notes WHERE subject = '$subject' ORDER BY 
        CAST(SUBSTRING_INDEX(chapter, '.', 1) AS UNSIGNED),
        SUBSTRING(chapter, LOCATE('.', chapter) + 2)
        ";

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
    echo json_encode(["error" => "Subject parameter is missing"]);
}

// Close the database connection
mysqli_close($conn);
?>
