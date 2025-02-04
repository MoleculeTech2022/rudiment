<?php
include 'dbcon.php';

// Check if note ID is provided in the query parameters
if(isset($_GET['id'])) {
    $note_id = $_GET['id'];

    // Fetch the note details from the database based on the provided note ID
    $sql = "SELECT * FROM h_ipsc_notes WHERE note_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $note_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Note details fetched successfully, display the edit form
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Note</title>
        </head>
        <body>
            <h1>Edit Note</h1>
            <form action="update_note.php" method="POST">
                <input type="hidden" name="note_id" value="<?php echo $row['note_id']; ?>">
                <input type="text" name="subject" value="<?php echo $row['subject']; ?>" placeholder="Subject"><br>
                <input type="text" name="chapter" value="<?php echo $row['chapter']; ?>" placeholder="Chapter"><br>
                <input type="text" name="subtopic" value="<?php echo $row['subtopic']; ?>" placeholder="Subtopic"><br>
                <input type="date" name="date" value="<?php echo $row['date']; ?>" placeholder="Date"><br>

                <textarea name="note" placeholder="Note" style="width:1000px;height:350px;"><?php echo $row['note']; ?></textarea><br>
                <button type="submit" name="update_note_btn" style="width:150px;height:45px;margin-top:20px;">Update Note</button>
            </form>
        </body>
        </html>

        <?php
    } else {
        echo "Note not found!";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Note ID not provided!";
}

// Close connection
$con->close();
?>
