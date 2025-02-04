<?php
include 'dbcon.php'; // Include the database connection file to establish connection

// Check if the form is submitted with the update button
if(isset($_POST['update_note_btn'])) {
    // Retrieve form data including the note ID and other details
    $note_id = $_POST['note_id'];
    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $subtopic = $_POST['subtopic'];

    // Prepare the SQL update statement
    $sql = "UPDATE h_ipsc_notes SET subject=?, chapter=?, date=?, note=?, subtopic=? WHERE note_id=?";

    // Prepare the statement and bind parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssi", $subject, $chapter, $date, $note, $subtopic, $note_id);

    // Execute the update statement
    if ($stmt->execute()) {
        // Redirect the user back to the display_notes.php page upon successful update
        header("Location: add_notes_sw.php");
        exit();
    } else {
        // If there's an error with the SQL execution, display an error message
        echo "Error updating note: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$con->close();
?>
