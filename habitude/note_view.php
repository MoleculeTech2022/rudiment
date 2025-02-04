<?php
// Include db connection file
include 'dbcon.php';

// Check if note_id is set in the URL
if(isset($_GET['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($conn, $_GET['note_id']);

    // Query to fetch details from the database based on note_id
    $sql = "SELECT * FROM i_upsc_notes WHERE note_id = '$note_id'";
    $result = $conn->query($sql);

    // Check if result is not empty
    if ($result->num_rows > 0) {
        // Fetch data
        $row = $result->fetch_assoc();
        $subject = $row['subject'];
        $date = $row['date'];
        $chapter = $row['chapter'];
        $subtopic = $row['subtopic'];
        $note = $row['note'];
    } else {
        // If no matching record found, display error message or redirect
        // For example:
        // header("Location: notes.php");
        // exit();
        echo "No record found";
    }
} else {
    // If note_id is not set in the URL, display error message or redirect
    // For example:
    // header("Location: notes.php");
    // exit();
    echo "Note ID is missing";
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Font Awesome Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="style.css">
        
    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>HABITUDE Edit Notes</title>

</head>
<body style="background-color:#fff;">
    
    <?php
    include "navbar.html";
    ?>

    <div class="add_section" style="margin-top: 80px; align-items: center;">
        <!-- <span style="font-size: 20px; margin-left: 15px;">Note Details</span> -->

        <div class="first-layer-container" style="display:flex;">

        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Subtopic : " . $subtopic ?></span>
        </div>

        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Date : " . $date ?></span>
        </div>

        <a href="note_edit.php?note_id=<?= $note_id ?>" style="text-decoration:none;">
            <button onclick="backPage()" style="width: 150px; height: 45px; background-color: #75ffbe; border: none; border-radius: 2px; color: #fff;margin-left:20px;">Edit Notes</button>
        </a>

        </div>

       <div class="first" style="display:flex;">

       <div class="row" style="margin-top:5px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Subject : " . $subject ?></span>
        </div>
        <br>
        <div class="row" style="margin-top:5px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Chapter : " . $chapter ?></span>
        </div>
       </div>
        <br>
       
        <br>
       
        <div class="row" style="margin-top:-25px;">
         <h4 style="font-size: 20px; margin-left: 15px;margin-top:15px;">Note :</h4>
        <?php
        // Split the note content by line breaks (\n) and display each line in a paragraph
        // $note_lines = explode("\n", $note);
        // foreach ($note_lines as $line) {
        //     echo "<p style='font-size: 16px; margin-left: 15px;'>$line</p>";
        // }
        ?>

<div class="note-data" style="margin-left:25px;">
<?php
// Sample note content
$note = $note;

// Split the note content by line breaks (\n) and display each line in a paragraph
$note_lines = explode("\n", $note);

// Check if note_lines is not empty and it's an array
if (!empty($note_lines) && is_array($note_lines)) {
    foreach ($note_lines as $line) {
        echo "<p style='font-size: 16px; margin-left: 20px; margin-bottom: 10px;'>$line</p>";
    }
} else {
    echo "No content found in the note.";
}
?>
            </div>  
        </div>
    </div>
</body>
</html>
