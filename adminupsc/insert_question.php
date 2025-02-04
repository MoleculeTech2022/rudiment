<?php
// Database connection
include('db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $question = $conn->real_escape_string($_POST['question']);
    $option_a = $conn->real_escape_string($_POST['option_a']);
    $option_b = $conn->real_escape_string($_POST['option_b']);
    $option_c = $conn->real_escape_string($_POST['option_c']);
    $option_d = $conn->real_escape_string($_POST['option_d']);
    $correct_option = $conn->real_escape_string($_POST['correct_option']);
    $explanation = $conn->real_escape_string($_POST['explanation']);
    $question_notes = $conn->real_escape_string($_POST['question_notes']);
    $question_subject = $conn->real_escape_string($_POST['question_subject']);
    $question_chapter = $conn->real_escape_string($_POST['question_chapter']);
    $question_topic = $conn->real_escape_string($_POST['question_topic']);
    $question_exam = $conn->real_escape_string($_POST['question_exam']);
    $question_level = $conn->real_escape_string($_POST['question_level']);
    $question_type = $conn->real_escape_string($_POST['question_type']);
    $question_ref = $conn->real_escape_string($_POST['question_ref']);
    $question_image = $conn->real_escape_string($_POST['question_image']);
    $dt = date("Y-m-d H:i:s");

    // SQL Query
    $sql = "INSERT INTO question_master 
            (question, option_a, option_b, option_c, option_d, correct_option, explanation, question_notes, question_subject, question_chapter, question_topic, question_exam, question_level, question_type, question_ref, question_image, dt) 
            VALUES ('$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$explanation', '$question_notes', '$question_subject', '$question_chapter', '$question_topic', '$question_exam', '$question_level', '$question_type', '$question_ref', '$question_image', '$dt')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        // Redirect to display_question.php after successful insertion
        header("Location: display_questions.php");
        exit();
    } else {
        // Display detailed error
        echo "Error inserting question: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
