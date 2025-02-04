<?php
// Database connection
include "dbcon.php";

// Get note_id from the request
$note_id = isset($_GET['note_id']) ? $_GET['note_id'] : die('Note ID parameter is missing');

// Fetch comments for the given note_id
$query = "SELECT * FROM note_comment WHERE note_id = $note_id ORDER BY note_id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Create an array to store comments
$comments = array();

// Fetch and store comments in the array
while ($row = mysqli_fetch_assoc($result)) {
    $comments[] = $row;
}

// Close the connection
mysqli_close($conn);

// Return the comments as JSON
header('Content-Type: application/json');
echo json_encode($comments);
?>
