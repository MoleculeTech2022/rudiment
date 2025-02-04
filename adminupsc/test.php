<?php
include('db.php');

header('Content-Type: application/json');

// Get the selected subject from the GET parameter
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
// chapter
$chapter = isset($_GET['chapter']) ? $_GET['chapter'] : '';
// No of Question
$noOfQuestion = isset($_GET['noOfQuestion']) ? $_GET['noOfQuestion'] : '';
// Question Reference
$questionRef = isset($_GET['questionRef']) ? $_GET['questionRef'] : '';

// echo $noOfQuestion; // for testing

if (empty($subject)) {
    echo json_encode(['error' => 'No subject provided in the request.']);
    exit;
}

// Prepare and execute the SQL query based on the subject
if ($subject === 'all') {
    if ($questionRef !== 'all') {
        // Query to fetch questions from all subjects but based on choosen Question Reference 
        $stmt = $conn->prepare("
                    SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                    FROM `question_master`
                    WHERE `question_ref` = ? 
                    ORDER BY RAND() 
                    LIMIT ?
                    ");
        $stmt->bind_param("si", $questionRef, $noOfQuestion);
    } else {
        // Query to fetch questions from all subjects
        $stmt = $conn->prepare("
                    SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                    FROM `question_master` 
                    ORDER BY RAND() 
                    LIMIT ?
                    ");
        $stmt->bind_param("i", $noOfQuestion);
    }
} elseif ($subject !== 'all'){
    if ($chapter === 'all'){
        if ($questionRef !== 'all') {
            // Query to fetch questions from choosen subjects but based on choosen Question Reference 
            $stmt = $conn->prepare("
                        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                        FROM `question_master`
                        WHERE `question_subject` = ? AND `question_ref` = ? 
                        ORDER BY RAND() 
                        LIMIT ?
                        ");
                        $stmt->bind_param("ssi", $subject, $questionRef, $noOfQuestion);
        } else {
                        // Query to fetch questions from choosen subjects
            $stmt = $conn->prepare("
                        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                        FROM `question_master` 
                        WHERE `question_subject` = ?  
                        ORDER BY RAND() 
                        LIMIT ?
                        ");
            $stmt->bind_param("si", $subject, $noOfQuestion);
        }
    }else{
        if ($questionRef !== 'all') {
            // Query to fetch questions from choosen subjects and choosen chapter but based on choosen Question Reference 
            $stmt = $conn->prepare("
                        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                        FROM `question_master`
                        WHERE `question_subject` = ? AND `question_chapter` = ? AND `question_ref` = ? 
                        ORDER BY RAND() 
                        LIMIT ?
                        ");
                        $stmt->bind_param("sssi", $subject, $chapter, $questionRef, $noOfQuestion);
        } else {
                        // Query to fetch questions from choosen subjects and choosen chapter 
            $stmt = $conn->prepare("
                        SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
                        FROM `question_master` 
                        WHERE `question_subject` = ?  AND `question_chapter` = ?
                        ORDER BY RAND() 
                        LIMIT ?
                        ");
            $stmt->bind_param("ssi", $subject, $chapter, $noOfQuestion);
        }
    }
}

    
// } elseif ($chapter === 'all') {
//     // Query to fetch questions based on the selected subject
//     $stmt = $conn->prepare("
//         SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
//         FROM `question_master` 
//         WHERE `question_subject` = ?
//         ORDER BY RAND() 
//         LIMIT ?
//     ");
//     $stmt->bind_param("si", $subject, $noOfQuestion);
// } else {
//     // Query to fetch questions based on the selected subject and chapter
//     $stmt = $conn->prepare("
//         SELECT `question_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `explanation` 
//         FROM `question_master` 
//         WHERE `question_subject` = ? AND `question_chapter` = ?
//         ORDER BY RAND() 
//         LIMIT ?
//     ");
//     $stmt->bind_param("ssi", $subject, $chapter, $noOfQuestion);
// }

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    // $questions[] = $row;

    // New Code for spacing error correction 
    // Apply nl2br and htmlspecialchars to each text field
    $row['question'] = nl2br(htmlspecialchars($row['question']));
    $row['option_a'] = nl2br(htmlspecialchars($row['option_a']));
    $row['option_b'] = nl2br(htmlspecialchars($row['option_b']));
    $row['option_c'] = nl2br(htmlspecialchars($row['option_c']));
    $row['option_d'] = nl2br(htmlspecialchars($row['option_d']));
    $row['explanation'] = nl2br(htmlspecialchars($row['explanation']));

    // Add the sanitized row to the questions array
    $questions[] = $row;
}

// Check if questions were found
if (empty($questions)) {
    echo json_encode(['error' => 'No questions found for the selected subject.']);
} else {
    echo json_encode($questions);
}

$conn->close();
