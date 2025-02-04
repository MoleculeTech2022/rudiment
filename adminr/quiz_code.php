<?php

// database connection
include 'dbcon.php';

// Check if the form is submitted
if(isset($_POST['add_note_btn'])) {
    
    // Get form data
    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $subtopic = $_POST['subtopic'];

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO h_ipsc_notes (subject, subtopic, note, date, chapter) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $subject, $subtopic, $note, $date, $chapter);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Check if the form is submitted
if(isset($_POST['insert_btn'])) {
    
    // Get form data
    $subject = $_POST['subject'];
    $subtopic = $_POST['subtopic'];
    $question = $_POST['question'];
    $option_one = $_POST['option_one'];
    $option_two = $_POST['option_two'];
    $option_three = $_POST['option_three'];
    $option_four = $_POST['option_four'];
    $answer = $_POST['answer'];
    $explanation = $_POST['explanation'];
    $chapter = $_POST['chapter'];
    $level = $_POST['level'];

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO quiz (subject, subtopic, question, option_one, option_two, option_three, option_four, answer, explanation, chapter, level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $subject, $subtopic, $question, $option_one, $option_two, $option_three, $option_four, $answer, $explanation, $chapter, $level);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$con->close();

?>
