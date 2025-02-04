<?php
// Database credentials

include "dbcon.php";

// Get data from POST request
$fname = $_POST['fname'];
$lname = $_POST['lname'];

// Insert data into MySQL database
$sql = "INSERT INTO android (fname, lname) VALUES ('$fname', '$lname')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
