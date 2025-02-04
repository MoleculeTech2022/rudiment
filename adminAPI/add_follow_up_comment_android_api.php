<?php
// Database credentials

include "dbcon.php";

// Get data from POST request
$pros_id = $_POST['pros_id'];
$dof = $_POST['dof'];
$followby = $_POST['followby'];
$followmode = $_POST['followmode'];
$comment = $_POST['comment'];
$nextstep = $_POST['nextstep'];

// Insert data into MySQL database
$sql = "INSERT INTO followup (pros_id,dof,followby,followmode,comment, nextstep) VALUES ('$pros_id', '$dof', '$followby', '$followmode', '$comment', '$nextstep')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
