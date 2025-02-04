<?php
// Include your database connection code
include "dbcon.php";

// Check if the search parameter is set
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // SQL query to filter students based on the search input
    $sql = "SELECT * FROM students
            JOIN complaint ON students.sid = complaint.sid
            WHERE fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%' OR classAdmitted LIKE '%$search%' OR complaint LIKE '%$search%' OR comtype LIKE '%$search%' OR comStatus LIKE '%$search%' OR `date` LIKE '%$search%'
            ORDER BY students.sid DESC";

    $count = 0;
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $status = $row['status'];
            $rowClass = '';

            if ($status == 'Active') {
                $rowClass = 'active-status';
            } elseif ($status == 'Pending') {
                $rowClass = 'pending-status';
            } elseif ($status == 'Suspended') {
                $rowClass = 'suspended-status';
            }

            echo '<tr>
                <td><input type="checkbox"></td>
                <td>' . $row['date'] . '</td>
                <td>
                    <a href="#" class="student-name-link" data-sid="' . $row['sid'] . '" style="text-decoration: none;color:#000;">
                        <span style="font-size:15px;">' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . '</span>
                    </a>
                    <br>
                    <span style="font-size:10px;">';

            $email = $row['email'];
            if (empty($email)) {
                echo $row['fname'] . "@gmail.com";
            } else {
                echo $email;
            }

            echo '</span>
                </td>
                <td>' . $row['comtype'] . '</td>
                <td>';

            $complaint = $row['complaint'];
            $words = explode(' ', $complaint);
            $limitedComplaint = implode(' ', array_slice($words, 0, 3)); // Limiting to 10 words
            echo $limitedComplaint . '...'; // Add an ellipsis if there are more words

            echo '</td>
                <td class="' . $rowClass . '">' . $row['comStatus'] . '</td>
                <td>
                    <a href="payment_due.php?sid=' . $row['sid'] . '" style="text-decoration:none;">
                        <i class="fa fa-ellipsis-v" style="margin-left:15px;"></i>
                    </a>
                    <a href="viewComplaint.php?cfid=' . $row['cfid'] . '" style="text-decoration:none;">
                        <i class="fa fa-edit" style="margin-left:15px;"></i>
                    </a>
                  
                </td>
            </tr>';

            $count++;
        }
    } else {
        echo "<tr><td colspan='6'>No results found.</td></tr>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>