<?php
// Database connection parameters
include "dbcon.php";

// Get selected qid from GET request
$qid = $_GET['qid'];

// Prepare and execute SQL query to fetch the question details for the given qid
$sql = "SELECT question, option_one, option_two, option_three, option_four, answer FROM questionbank WHERE qid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $qid);
$stmt->execute();
$stmt->bind_result($question, $option_one, $option_two, $option_three, $option_four, $answer);

// Fetch the result
if ($stmt->fetch()) {
    // Return the question details as JSON response
    echo json_encode(array(
        "qid" => $qid,
        "question" => $question,
        "option_one" => $option_one,
        "option_two" => $option_two,
        "option_three" => $option_three,
        "option_four" => $option_four,
        "answer" => $answer
    ));
} else {
    // If no question found for the given qid, return an error message
    echo json_encode(array("error" => "No question found for the given qid"));
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
