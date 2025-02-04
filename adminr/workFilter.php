<?php
// Include your database connection code
include "dbcon.php";

// Check if the search parameter is set
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // SQL query to filter students based on the search input
    $sql = "SELECT * FROM temporary
            JOIN students ON students.sid = temporary.sid
            WHERE fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%' OR classAdmitted LIKE '%$search%' OR text_one LIKE '%$search%'
            ORDER BY students.sid DESC";

    $count = 0;
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {


            echo "<tr>";
            echo "<td style='color:#000;'>" . ($count + 1) . "</td>"; // Corrected the concatenation
            echo "<td>{$row['fname']} {$row['mname']} {$row['lname']}</td>";
            echo "<td>{$row['classAdmitted']}</td>";
            echo "<td>{$row['text_one']}</td>";
            echo "<td>{$row['text_two']}</td>";
            echo "<td>{$row['text_three']}</td>"; // Corrected the echo statement
            echo "<td> <a href='student-view.php?sid=" . $row['sid'] . "' style='text-decoration:none;'>
            <i class='bx bx-id-card' style='margin-left:15px;'></i>
        </a> <a href='student-edit.php?sid=" . $row['sid'] . "'>
            <i class='fa fa-edit' style='margin-left:15px;'></i>
        </a></td>";
            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='6'>No results found.</td></tr>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>