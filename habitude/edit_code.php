<?php

include "dbcon.php";

// Check if the form is submitted for editing notes
if (isset($_POST['edit_notes_btn']) && isset($_POST['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($conn, $_POST['note_id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $chapter = mysqli_real_escape_string($conn, $_POST['chapter']);
    $subtopic = mysqli_real_escape_string($conn, $_POST['subtopic']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    if (!empty($note)) {
        // Update the note in the database
        $sql = "UPDATE i_upsc_notes 
            SET subject = '$subject', 
                date = '$date', 
                chapter = '$chapter', 
                subtopic = '$subtopic', 
                note = '$note', 
                dt = NOW() 
            WHERE note_id = '$note_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to notes.php after successful update
            header("Location: note_view.php?note_id=$note_id");
            exit();
        } else {
            // Display error message if update fails
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Handle the case where $note is empty
        echo "Note is empty. Cannot update.";
        // header("Location : note_edit.php?note_id=" . $note_id);
    }
}
?>