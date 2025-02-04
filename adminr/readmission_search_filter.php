<?php
// Include your database connection code
include "dbcon.php";

// Check if the search parameter is set
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // SQL query to filter students based on the search input
    $sql = "SELECT * FROM students
            JOIN parents ON students.sid = parents.sid     
            WHERE fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%' OR classAdmitted LIKE '%$search%' OR mcontact LIKE '%$search%'
            ORDER BY students.sid DESC";

    $count = 0;
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            $status = $rows['status'];
            $rowClass = '';

            if ($status == 'Active') {
                $rowClass = 'active-status';
            } elseif ($status == 'Pending') {
                $rowClass = 'pending-status';
            } elseif ($status == 'Suspended') {
                $rowClass = 'suspended-status';
            }

            echo '<tr>';
            echo '<td style="color:#000;">';
            echo $count + 1;
            echo '</td>';
            echo '<td>';
            echo '<a href="student-view.php?sid=' . $rows['sid'] . '" style="text-decoration: none;color:#000;">';
            echo '<span style="font-size:15px;">';
            echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname'];
            echo '</span>';
            echo '</a>';
            echo '<br>';
            echo '<span style="font-size:10px;">';
            echo $rows['fname'] . "@gmail.com";
            echo '</span>';
            echo '</td>';
            echo '<td>';
            echo $rows['current_class'];
            echo '</td>';
            echo '<td>';
            echo $rows['doa'];
            echo '</td>';
            echo '<td>';
            echo $rows['mcontact'];
            echo '</td>';
            echo '<td class="' . $rowClass . '">';
            echo $status;
            echo '</td>';
            echo '<td>';
            echo '<a href="readmission_view.php?sid=' . $rows['sid'] . '">';
            echo '<button style="width:70px;height:55px;border-radius:10px;">View</button>';
            echo '</a>';
            echo '</td>';
            echo '</tr>';
            $count++;
        }
    } else {
        echo "<tr><td colspan='6'>No results found.</td></tr>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>