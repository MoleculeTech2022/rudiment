<?php
// Establish MySQL connection
include "dbcon.php";

// Fetch data from MySQL
$sql = "SELECT * FROM prospect";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $prospects = array();
    while ($row = $result->fetch_assoc()) {
        $prospects[] = $row;
    }
    echo json_encode($prospects);
} else {
    echo "0 results";
}
$conn->close();
?>