<?php
include 'dbcon.php';

// Check if sid parameter is set
if(isset($_POST['sid'])) {
    // Retrieve sid parameter
    $sid = $_POST['sid'];

    // $sid = 1;

    // SQL query to fetch student details by mid
    $sql = "SELECT * FROM students
    JOIN parents ON parents.sid = students.sid
    WHERE sid = '$sid'";
    $result = mysqli_query($conn, $sql);

    // Check if result is not empty
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Prepare response array
        $response = array(
            'fname' => $row['fname'],
            'mname' => $row['mname'],
            'lname' => $row['lname'],
            'mcontact' => $row['mcontact'],
            'fcontact' => $row['fcontact']
        );
        // Encode response array to JSON format
        echo json_encode($response);
    } else {
        echo "No student found with the provided ID";
    }
} else {
    echo "Error : sid parameter is not set";
}

mysqli_close($conn);
?>
