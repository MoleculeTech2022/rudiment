<?php
// Establish MySQL connection
include "dbcon.php";

// Fetch data from MySQL
$sql = "SELECT * FROM i_upsc_notes ORDER BY dt DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $notes = array();
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
    echo json_encode($notes);
} else {
    echo "0 results";
}
$conn->close();
?>