<?php
// Database connection
include('db.php');

// Initialize response structure
$response = [
    "total" => 0,
    "subjectWiseCounts" => [],
    "questions" => []
];

// Fetch total questions count
$totalQuery = "SELECT COUNT(*) AS total FROM question_master";
$totalResult = $conn->query($totalQuery);
if ($totalResult && $row = $totalResult->fetch_assoc()) {
    $response["total"] = $row["total"];
}

// Fetch subject-wise question counts
$subjectQuery = "SELECT question_subject, COUNT(*) AS count FROM question_master GROUP BY question_subject";
$subjectResult = $conn->query($subjectQuery);
if ($subjectResult) {
    while ($row = $subjectResult->fetch_assoc()) {
        $response["subjectWiseCounts"][$row["question_subject"]] = $row["count"];
    }
}

// Fetch all questions
$questionsQuery = "SELECT question_id, question_exam, question_subject, question_level, question_chapter, question_topic, question, option_a, option_b, option_c, option_d, correct_option FROM question_master ORDER BY question_id DESC";
$questionsResult = $conn->query($questionsQuery);
if ($questionsResult) {
    while ($row = $questionsResult->fetch_assoc()) {
        $response["questions"][] = $row;
    }
}

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
