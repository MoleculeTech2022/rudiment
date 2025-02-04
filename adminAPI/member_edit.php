<?php
include 'dbcon.php';

// Check if mid parameter is set
if(isset($_POST['mid'])) {
    // Retrieve mid parameter
    $mid = $_POST['mid'];

    // SQL query to fetch student details by mid
    $sql = "SELECT * FROM android WHERE mid = '$mid'";
    $result = mysqli_query($conn, $sql);

    // Check if result is not empty
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Prepare response array
        $response = array(
            'fname' => $row['fname'],
            'lname' => $row['lname']
        );
        // Encode response array to JSON format
        echo json_encode($response);
    } else {
        echo "No student found with the provided ID";
    }
} else {
    echo "Error : mid parameter is not set";
}

mysqli_close($conn);
?>
