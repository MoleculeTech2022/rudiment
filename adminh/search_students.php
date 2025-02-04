<?php
// Include your database connection code (e.g., dbcon.php)
include "dbcon.php";

if (isset($_GET['term'])) {
    $searchTerm = $_GET['term'];

    // Query the database to fetch student names based on the search term
    $query = "SELECT `sid`, `fname`, `mname`, `lname` FROM students WHERE CONCAT(`fname`, ' ', `mname`, ' ', `lname`) LIKE '%$searchTerm%'";
    $result = mysqli_query($con, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'value' => $row['sid'],
            'text' => $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']
        );
    }

    // Return JSON response
    echo json_encode($data);
} else {
    // Return an empty response if no search term is provided
    echo json_encode([]);
}

// Close the database connection
mysqli_close($con);
?>


 

<?php
// // Include the database connection
// include "dbcon.php";

// // Get the search term from the AJAX request
// $q = $_GET["q"];

// // Query to fetch matching records from the database
// $query = "SELECT sid, CONCAT(fname, ' ', mname, ' ', lname) AS full_name FROM students WHERE CONCAT(fname, ' ', mname, ' ', lname) LIKE '%$q%'";
// $result = mysqli_query($con, $query);

// $results = [];

// if ($result) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $results[] = [
//             "id" => $row['sid'],
//             "text" => $row['full_name']
//         ];
//     }
// }

// // Return the results as JSON
// header('Content-Type: application/json');
// echo json_encode($results);
?> 
