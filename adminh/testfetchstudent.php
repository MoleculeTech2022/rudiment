<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Require the "dbcon.php" file for database connection
require "dbcon.php";

// Execute a SQL query to select student names from the database
$result = mysqli_query($con, "SELECT fname, mname, lname FROM students");

// Create a dropdown select element
echo "<select id='search'>";
echo "<option>---Student List---</option>";

// Loop through the results and populate the select options with student names
while ($row = mysqli_fetch_array($result)) {
    echo "<option>$row[fname] $row[mname] $row[lname]</option>";
}

// Close the database connection
mysqli_close($con);
?>


<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<!-- Include Chosen CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

<!-- Include Chosen jQuery plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<!-- Initialize Chosen on the 'search' select element -->
<script>
    // Initialize Chosen on the 'search' select element
    $('#search').chosen();
</script>
</body>
</html>