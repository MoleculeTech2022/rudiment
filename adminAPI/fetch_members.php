<?php
include 'dbcon.php';

$sqlFetchStudents = "SELECT * FROM android";
$resultFetchStudents = mysqli_query($conn, $sqlFetchStudents);
$rows = array();

if ($resultFetchStudents) {
    while ($row = mysqli_fetch_assoc($resultFetchStudents)) {
        array_push(
            $rows,
            array(
                'mid' => $row['mid'],
                'fname' => $row['fname'],
                'lname' => $row['lname']
            )
        );
    }
    echo json_encode($rows);
} else {
    echo "some error";
}

mysqli_close($conn); // Close the database connection
?>
