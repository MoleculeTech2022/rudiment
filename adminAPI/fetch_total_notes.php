<?php
// fetch_total_notes.php
include 'dbcon.php'; // Include the database connection file

// SQL query to count total notes
$sql = "SELECT COUNT(*) AS total_notes FROM i_upsc_notes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $total_notes = $row["total_notes"];
        echo $total_notes;
    }
} else {
    echo "0 results";
}

$conn->close();
?>
