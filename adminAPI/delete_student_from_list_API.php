<?php

include 'dbcon.php';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "marketing";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// an array to display response
$response = array();

// Check if the 'sid' parameter is present in the request
if(isset($_POST['sid'])){
    // if the 'sid' parameter is present, extract its value
    $sid = $_POST['sid'];

    // write an SQL query to delete the record with the specified sid from the 'normal_list' table
    $stmt = $conn->prepare("DELETE FROM `normal_list` WHERE `sid` = ?");
    $stmt->bind_param("i", $sid);

    // Check if the delete query is executed successfully
    if($stmt->execute() == TRUE){
        // if the script is executed successfully, pass data to the response object with a success message
        $response['error'] = false;
        $response['message'] = "Student deleted from Master List successfully!";
    } else {
        // if there is an error, pass an error message to the response object
        $response['error'] = true;
        $response['message'] = "Failed to delete\n ".$conn->error;
    }
} else {
    // if 'sid' parameter is not present in the request, pass an error message to the response object
    $response['error'] = true;
    $response['message'] = "Insufficient parameters";
}

// print the response
echo json_encode($response);
?>
