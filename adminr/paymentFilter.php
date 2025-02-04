<?php
// Include your database connection code
include "dbcon.php";

// Check if the search parameter is set
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // SQL query to filter students based on the search input
    $sql = "SELECT * FROM students
            JOIN payment ON students.sid = payment.sid
            WHERE fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%' OR paydate LIKE '%$search%' OR payamt LIKE '%$search%' OR paymode LIKE '%$search%'
            ORDER BY payment.paydate DESC";

    $result = mysqli_query($con, $sql);
    $no = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {

            $email = $rows['email'];
            $status = $rows['status'];
            $rowClass = '';

            if ($status == 'Active') {
                $rowClass = 'active-status';
            } elseif ($status == 'Pending') {
                $rowClass = 'pending-status';
            } elseif ($status == 'Suspended') {
                $rowClass = 'suspended-status';
            }
            echo "<tr>";
            echo "<td><span style='color:#000;'>" . $no + 1 . "</span></td>";
            echo "<td>{$rows['paydate']}</td>";
            echo "<td>{$rows['payamt']}</td>";
            echo "<td>{$rows['paymode']}</td>";
            echo "<td><span>{$rows['fname']} {$rows['mname']} {$rows['lname']}</span><br>";
            echo "</td>";
            echo "<td> <a href='payment_due.php?sid=" . $rows['sid'] . "' style='text-decoration:none;'>
            <i class='fa fa-eye' style='margin-left:15px;'></i>
        </a> <a href='payment_edit.php?payid=" . $rows['payid'] . "'>
            <i class='fa fa-edit' style='margin-left:15px;'></i>
        </a></td>";
            echo "</tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='6'>No results found.</td></tr>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>