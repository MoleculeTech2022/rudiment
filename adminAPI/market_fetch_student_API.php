<?php
// include 'dbcon.php';
include "dbcon.php";

$sqlFetchStudents = "SELECT * FROM marketing
ORDER BY marketing.sid DESC";
$resultFetchStudents = mysqli_query($conn, $sqlFetchStudents);
if (!$resultFetchStudents) {
    echo "Something Wrong Try Again";
}
$rows = array();
$count = 1;
while ($row = mysqli_fetch_assoc($resultFetchStudents)) {
    array_push(
        $rows,
        array(
            'sid' => $row['sid'],
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'forclass' => $row['forclass'],
            'mcontact' => $row['mcontact']
        )
    );
    $count++;
}

echo json_encode($rows);
mysqli_close($conn); // Close the database connection
?>