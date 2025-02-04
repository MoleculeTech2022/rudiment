<?php
// Include database connection
include 'dbcon.php';

// Check the request type
$type = $_GET['type'] ?? null;

if ($type === 'subjects') {
    // Fetch subjects
    $query = "SELECT hab_subject FROM habitude_subjects";
    $result = $conn->query($query);

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['hab_subject'];
    }
    echo json_encode($subjects);

} elseif ($type === 'sub_subjects') {
    // Fetch sub-subjects based on subject
    $subject = $_GET['hab_subject'] ?? '';
    $stmt = $conn->prepare("SELECT hab_sub_subject FROM habitude_sub_subjects WHERE hab_subject = ?");
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    $subSubjects = [];
    while ($row = $result->fetch_assoc()) {
        $subSubjects[] = $row['hab_sub_subject'];
    }
    echo json_encode($subSubjects);

} else {
    echo json_encode(["error" => "Invalid request"]);
}
$conn->close();
?>
