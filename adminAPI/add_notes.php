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
if (isset($_POST['date'])) {
    // extract values from POST parameters
    // $sid =2;
    // $payamt = 234;
    // $paydate = '12-12-2023';
    // $paymode = 'Cash';
    // $acdyear = "2023-24";
    $date = $_POST['date'];
    $subject = $_POST['subject'];
    $subtopic = $_POST['subtopic'];
    $chapter = $_POST['chapter'];
    $note = $_POST['note'];

    // prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO i_upsc_notes (`date`,subject,subtopic,chapter,note) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $date, $subject, $subtopic, $chapter, $note);

    // execute the statement
    if ($stmt->execute()) {
        // if successful, set success message in response
        $response['error'] = false;
        $response['message'] = "Note Inserted Succesfully";
    } else {
        // if failed, set error message in response
        $response['error'] = true;
        $response['message'] = "Failed to insert note data: " . $conn->error;
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
