<?php

// database connection
include "dbcon.php";

// Retrieve data from POST request
$note_id = mysqli_real_escape_string($conn, $_POST['note_id']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$chapter = mysqli_real_escape_string($conn, $_POST['chapter']);
$subtopic = mysqli_real_escape_string($conn, $_POST['subtopic']);
$note = mysqli_real_escape_string($conn, $_POST['note']);

// SQL query to update student data
$sql_student = "UPDATE i_upsc_notes
                SET date = '$date', 
                    subject = '$subject', 
                    chapter = '$chapter', 
                    subtopic = '$subtopic', 
                    note = '$note',
                    dt = NOW()
                WHERE note_id = '$note_id'";

// Execute queries
$sql_query_run_student = mysqli_query($conn, $sql_student);

if (mysqli_affected_rows($conn) > 0) {
    echo "Data updated successfully";
} else {
    echo "No records updated for the provided ID";
}

// Close connection
mysqli_close($conn);
?>
