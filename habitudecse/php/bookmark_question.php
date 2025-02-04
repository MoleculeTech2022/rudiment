<?php
include('../php/db_connect.php');

// Get POST data
$question_id = $_POST['question_id'];
$user_id = $_POST['user_id'];  // Assuming the user is logged in

// Insert the bookmark into the database
$query = "INSERT INTO bookmarks (hab_id, question_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $question_id);

if ($stmt->execute()) {
    echo "Bookmark saved successfully.";
} else {
    echo "Error saving bookmark.";
}

$stmt->close();
$conn->close();
?>
