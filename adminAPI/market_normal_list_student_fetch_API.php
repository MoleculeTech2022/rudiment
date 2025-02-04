<?php
include 'dbcon.php';
// $con = mysqli_connect("localhost", "root", "", "marketing");

// if (!$con) {
//     die('Connection Failed' . mysqli_connect_error());
// }

$sqlFetchStudents = "SELECT * FROM normal_list
ORDER BY normal_list.sid DESC";

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