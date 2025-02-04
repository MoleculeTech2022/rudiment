<?php
// Database connection parameters
include "dbcon.php";

// Get selected class from GET request
$subject = $_GET['subject'];

// Prepare and execute SQL query to fetch a random qid from the specified class
$sql = "SELECT * FROM quiz WHERE subject = '$subject' ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();
    // Return the qid as JSON response
    echo json_encode(array(
        "question_id" => $row['question_id'],
        "question" => $row['question'],
        "subtopic" => $row['subtopic'],
        "chapter" => $row['chapter'],
        "level" => $row['level'],
        "option_one" => $row['option_one'],
        "option_two" => $row['option_two'],
        "option_three" => $row['option_three'],
        "option_four" => $row['option_four'],
        "answer" => $row['answer'],
        "explanation" => $row['explanation']
    ));
} else {
    // If no qid found, return an error message
    echo json_encode(array("error" => "No question_id found for the subject class"));
}

// Close the connection
$conn->close();
?>