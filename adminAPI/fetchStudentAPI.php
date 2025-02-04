<?php
// // Establish MySQL connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "rudiment_db";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

include "dbcon.php";

// Fetch data from MySQL
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $students = array();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    echo json_encode($students);
} else {
    echo "0 results";
}
$conn->close();
?>