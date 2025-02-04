<?php
// Connection parameters
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "rudiment_db";

// // Create a connection to the database
// $conn = mysqli_connect($host, $username, $password, $database);

// // Check the connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

include 'dbcon.php';


// Check if 'sid' is provided in the request
if (isset($_POST['sid'])) {
    // Sanitize and retrieve the student ID
    $sid = mysqli_real_escape_string($con, $_POST['sid']);

    // Query to retrieve student details based on the provided student ID
    $query = "SELECT * FROM students WHERE sid = '$sid'";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);

        // Check if a student was found with the provided ID
        if ($row) {
            // Create an associative array to store the student details
            $studentDetails = array(
                'fname' => $row['fname'],
                'dob' => $row['dob']
                // Add more fields as needed
            );

            // Send the JSON response
            header('Content-Type: application/json');
            echo json_encode($studentDetails);
        } else {
            // No student found with the provided ID
            echo "No student found with the provided ID";
        }
    } else {
        // Error in the query
        echo "Error: " . mysqli_error($con);
    }
} else {
    // 'sid' not provided in the request
    echo "Student ID (sid) not provided in the request";
}

// Close the database connection
mysqli_close($con);
?>