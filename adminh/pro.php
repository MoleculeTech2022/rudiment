<!DOCTYPE html>
<html>
<head>
    <title>Count Students</title>
</head>
<body>

<h1>Count of Students</h1>

<?php
// Database connection settings
require "dbcon.php";

// SQL query to count students
$query = "SELECT COUNT(*) AS student_count FROM students";

// Execute the query
$result = mysqli_query($con, $query);

// Check if the query was successful
if ($result) {
    // Fetch the count
    $row = mysqli_fetch_assoc($result);
    $studentCount = $row['student_count'];

    // Display the count
    echo "<p>Total number of students: $studentCount</p>";

    // Free the result set
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

</body>
</html>
