<?php

include "dbcon.php";

// Check if the form is submitted for editing notes
if(isset($_POST['edit_notes_btn']) && isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($con, $_POST['note_id']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $chapter = mysqli_real_escape_string($con, $_POST['chapter']);
    $subtopic = mysqli_real_escape_string($con, $_POST['subtopic']);
    $note = mysqli_real_escape_string($con, $_POST['note']);

    // Update the note in the database
    $sql = "UPDATE i_upsc_notes SET subject = '$subject', date = '$date', chapter = '$chapter', subtopic = '$subtopic', note = '$note' WHERE note_id = '$note_id'";
    if ($con->query($sql) === TRUE) {
        // Redirect back to notes.php after successful update
        header("Location: notes.php");
        exit();
    } else {
        // Display error message if update fails
        echo "Error updating record: " . $con->error;
    }
}


?>