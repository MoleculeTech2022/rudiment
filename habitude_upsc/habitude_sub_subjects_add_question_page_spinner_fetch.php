<?php
// Include database connection file
include('dbcon.php');

// Get the 'hab_subject' from the GET request or set it to null if not provided
$hab_subject = isset($_GET['hab_subject']) ? $_GET['hab_subject'] : null;

if ($hab_subject) {
    // SQL query to fetch sub-subjects based on the selected subject
    $query = "SELECT hab_sub_subject FROM habitude_sub_subjects WHERE hab_subject = '$hab_subject'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Create an array to store sub-subjects
        $subSubjects = array();

        // Fetch all sub-subjects from the result
        while ($row = mysqli_fetch_assoc($result)) {
            $subSubjects[] = $row['hab_sub_subject'];
        }

        // Return the sub-subjects as JSON
        echo json_encode($subSubjects);
    } else {
        // Return an error message if the query fails
        echo json_encode(["error" => "Query failed"]);
    }
} else {
    // If 'hab_subject' is missing, return an empty JSON array
    echo json_encode([]);
}
?>
