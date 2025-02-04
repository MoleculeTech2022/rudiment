<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rudiment";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the selected class filter from the form
$class_filter = $_POST['class_filter'];

// Construct the SQL query based on the selected filter
$sql = "SELECT * FROM students";
if (!empty($class_filter)) {
    $sql .= " WHERE sclass = '$class_filter'";
}

// Execute the SQL query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the filtered students
    echo "<h2>Filtered Students:</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["id"] . ": " . $row["class"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No students found with the selected class filter.";
}

// Close the database connection
$conn->close();
?>
