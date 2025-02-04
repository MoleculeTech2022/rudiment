<?php
include 'dbcon.php'; // Database connection

$sql = "SELECT question_id, question, option_a, option_b, option_c, option_d FROM question_master";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Push each row into data array
    }
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "error", "message" => "No questions found"));
}

$conn->close();
?>
