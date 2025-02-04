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
if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO habitude_user (email,password,username) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $username);

    // execute the statement
    if ($stmt->execute()) {
        // if successful, set success message in response
        $response['error'] = false;
        $response['message'] = "User Created Succesfully";
    } else {
        // if failed, set error message in response
        $response['error'] = true;
        $response['message'] = "Failed to insert user data: " . $con->error;
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
?>