<?php
session_start();
require 'dbcon.php';

// Check if the 'search' and 'academic_year' parameters are set
if(isset($_POST['search']) && isset($_POST['academic_year'])) {
    $searchText = $_POST['search'];
    $academicYear = $_POST['academic_year'];

    // Construct the SQL query
    $query = "SELECT * FROM payment 
              JOIN students ON payment.sid = students.sid 
              WHERE students.acdyear = '$academicYear'";

    // Add search condition if search text is provided
    if (!empty($searchText)) {
        $searchText = mysqli_real_escape_string($con, $searchText); // Sanitize input
        $query .= " AND (students.fname LIKE '%$searchText%' OR students.mname LIKE '%$searchText%' OR students.lname LIKE '%$searchText%')";
    }

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $student) {
                // Output your table rows here as before
                // Example:
                echo '<tr>';
                echo '<td>' . $student['sid'] . '</td>';
                echo '<td>' . $student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname'] . '</td>';
                echo '<td>' . $student['acdyear'] . '</td>';
                echo '<td>' . $student['payamt'] . '</td>';
                echo '<td>' . $student['paydate'] . '</td>';
                echo '<td>';
                echo '<a href="student-view.php?sid=' . $student['sid'] . '" style="text-decoration:none;">';
                echo '<i class="bx bx-show icon"></i>';
                echo '</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='6'>No Record Found</td></tr>";
        }
    } else {
        // Handle query execution error
        echo "Query execution failed: " . mysqli_error($con);
    }
} else {
    echo "Invalid parameters"; // Handle missing or invalid parameters
}

?>
