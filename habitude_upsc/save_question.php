<?php
// Include database connection
include 'dbcon.php';

// Get form data
// $subject = $_POST['subject'] ?? '';
// $subSubject = $_POST['sub_subject'] ?? '';
$question = $_POST['question'] ?? '';
$optionA = $_POST['option_a'] ?? '';
$optionB = $_POST['option_b'] ?? '';
$optionC = $_POST['option_c'] ?? '';
$optionD = $_POST['option_d'] ?? '';
$correctOption = $_POST['correct_option'] ?? '';

// Check if all fields are filled
if ($question && $optionA && $optionB && $optionC && $optionD && $correctOption) {
    // Insert data into the database
    $query = "INSERT INTO question_master ( question, option_a, option_b, option_c, option_d, correct_option) 
              VALUES ('$question', '$optionA', '$optionB', '$optionC', '$optionD', '$correctOption')";
    
    if ($conn->query($query)) {
        echo "Question added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Please fill all fields!";
}

$conn->close();
?>
