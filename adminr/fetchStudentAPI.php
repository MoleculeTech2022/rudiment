<?php
include 'dbcon.php';
// $con = mysqli_connect("localhost", "root", "", "rudiment_db");

if (!$con) {
    die('Connection Failed' . mysqli_connect_error());
}

$sqlFetchStudents = "SELECT * FROM students
JOIN acdyear ON acdyear.sid = students.sid 
WHERE acdyear.acdyear = '2023-24'
 ORDER BY students.sid DESC";
$resultFetchStudents = mysqli_query($con, $sqlFetchStudents);
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
            'count' => $count,
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'total_fees' => $row['total_fees'],
            'classAdmitted' => $row['classAdmitted']
        )
    );
    $count++;
}

echo json_encode($rows);
mysqli_close($con); // Close the database connection
?>