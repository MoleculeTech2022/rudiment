<?php
// Database connection parameters
include "dbcon.php";
// $servername = "localhost"; // Change this to your database host
// $username = "root"; // Change this to your database username
// $password = ""; // Change this to your database password
// $database = "rudiment_db"; // Change this to your database name

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $database);

// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Retrieve data from POST request
$sname = $_POST['sname']; // Assuming 'fname' is the key sent from Android app
$enrollclass = $_POST['enrollclass']; // Assuming 'fname' is the key sent from Android app
$dov = $_POST['dov']; // Similarly, retrieve other fields
$mcontact = $_POST['mcontact'];
$fcontact = $_POST['fcontact'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

// Escape special characters in SQL to prevent SQL injection
$sname = mysqli_real_escape_string($conn, $sname);
$enrollclass = mysqli_real_escape_string($conn, $enrollclass);
$dov = mysqli_real_escape_string($conn, $dov);
$mcontact = mysqli_real_escape_string($conn, $mcontact);
$fcontact = mysqli_real_escape_string($conn, $fcontact);
$status = mysqli_real_escape_string($conn, $status);
$remarks = mysqli_real_escape_string($conn, $remarks);

// SQL query to insert data into table
$sql = "INSERT INTO prospect (sname, enrollclass, dov, mcontact,fcontact, status,remarks)
         
        VALUES ('$sname', '$enrollclass', '$dov', '$mcontact', '$fcontact', '$status', '$remarks')";

          $sql_quer_run = mysqli_query($conn,$sql);

      
if ($sql_quer_run) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
