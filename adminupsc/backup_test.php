<?php
include('db.php');

header('Content-Type: application/json');

// Get the selected subject from the GET parameter
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
// chapter
$chapter = isset($_GET['chapter']) ? $_GET['chapter'] : '';
// No of Question
$noOfQuestion = isset($_GET['noOfQuestion']) ? $_GET['noOfQuestion'] : '';
// $noOfQuestion = 3;


// echo $noOfQuestion; // for testing

if (empty($subject)) {
    echo json_encode(['error' => 'No subject provided in the request.']);
    exit;
}

// Prepare and execute the SQL query based on the subject
// if ($subject === 'all' && $chapter === 'all') {
if ($subject === 'all') {
    // Query to fetch questions from all subjects
    $stmt = $conn->prepare("
        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
        FROM `question_master` 
        ORDER BY RAND() 
        LIMIT ?
    ");
    $stmt->bind_param("i",$noOfQuestion);

} elseif ($chapter === 'all') {
    // Query to fetch questions based on the selected subject
    $stmt = $conn->prepare("
        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
        FROM `question_master` 
        WHERE `question_subject` = ? && `question_chapter` = ?
        ORDER BY RAND() 
        LIMIT ?
    ");
    $stmt->bind_param("ssi", $subject,$chapter,$noOfQuestion);

}
else {
    // Query to fetch questions based on the selected subject
    $stmt = $conn->prepare("
        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
        FROM `question_master` 
        WHERE `question_subject` = ? && `question_chapter` = ?
        ORDER BY RAND() 
        LIMIT ?
    ");
    $stmt->bind_param("ssi", $subject,$chapter,$noOfQuestion);

}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

// Check if questions were found
if (empty($questions)) {
    echo json_encode(['error' => 'No questions found for the selected subject.']);
} else {
    echo json_encode($questions);
}

$conn->close();
?>
