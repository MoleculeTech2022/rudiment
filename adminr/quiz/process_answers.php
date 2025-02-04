<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the submitted answers
    $correct_answers = array(); // Array to store correct answers (you may fetch these from the database)
    $total_questions = 5; // Total number of questions in the exam

    // Assuming your correct answers are stored in an array with keys like 'answer1', 'answer2', etc.
    for ($i = 1; $i <= $total_questions; $i++) {
        // Check if the answer is submitted for the current question
        if (isset($_POST['answer' . $i])) {
            // Get the submitted answer
            $submitted_answer = $_POST['answer' . $i];

            // Compare with the correct answer (replace 'YOUR_CORRECT_ANSWERS_ARRAY' with your actual array of correct answers)
            if ($submitted_answer == $correct_answers['answer' . $i]) {
                echo "Question " . $i . ": Correct<br>";
            } else {
                echo "Question " . $i . ": Incorrect<br>";
            }
        } else {
            echo "Question " . $i . ": No answer submitted<br>";
        }
    }
} else {
    // Redirect back to the form if accessed directly
    header("Location: online_exam.php");
    exit();
}
?>