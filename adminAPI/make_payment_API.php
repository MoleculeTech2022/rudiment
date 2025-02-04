<?php

include 'dbcon.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "rudiment_db";

// // Create connection
// $con = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($con->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// array to store response data
$response = array();

// check if the required parameters are set
if (isset($_POST['sid'])) {
    // extract values from POST parameters
    // $sid =2;
    // $payamt = 234;
    // $paydate = '12-12-2023';
    // $paymode = 'Cash';
    // $acdyear = "2023-24";
    $sid = $_POST['sid'];
    $payamt = $_POST['payamt'];
    $paydate = $_POST['paydate'];
    $paymode = $_POST['paymode'];
    $acdyear = "2023-24";

    // prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO android (`sid`,payamt,paydate,paymode,acdyear) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $sid, $payamt, $paydate, $paymode, $acdyear);

    // execute the statement
    if ($stmt->execute()) {
        // if successful, set success message in response
        $response['error'] = false;
        $response['message'] = "Payment Inserted Succesfully";
    } else {
        // if failed, set error message in response
        $response['error'] = true;
        $response['message'] = "Failed to insert payment data: " . $conn->error;
    }

    // close the statement
    $stmt->close();
} else {
    // if parameters are not set, set error message in response
    $response['error'] = true;
    $response['message'] = "Insufficient parameters";
}
// close the database connection

// encode the response in JSON format and echo it
echo json_encode($response);
