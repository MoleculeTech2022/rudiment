<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "habitude";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and wrap in <strong> tags
$fname = "<strong>" . $_POST['fname'] . "</strong>";
$lname = "<strong>" . $_POST['lname'] . "</strong>";

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO sample (fname, lname) VALUES (?, ?)");
$stmt->bind_param("ss", $fname, $lname);

// Execute the statement
if ($stmt->execute()) {
    echo "<strong>New record created successfully</strong><br>";
    echo "You entered: " . htmlspecialchars($fname) . " " . htmlspecialchars($lname);
} else {
    echo "<strong>Error: " . $stmt->error . "</strong>";
}

// Close connection
$stmt->close();
$conn->close();
?>
