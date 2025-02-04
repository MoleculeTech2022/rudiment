<?php
session_start();
require 'dbcon.php';

if (isset($_POST['search'])) {
    $searchText = trim($_POST['search']); // Trim leading and trailing spaces
    $searchWords = explode(' ', $searchText); // Split the input into individual words

    $query = "SELECT * FROM payment 
    JOIN students ON payment.sid = students.sid 
    JOIN acdyear ON payment.sid = acdyear.sid 
    WHERE ";

    $conditions = array();
    foreach ($searchWords as $word) {
        // Search first name, middle name, and last name separately
        $conditions[] = "fname LIKE '%$word%' OR mname LIKE '%$word%' OR lname LIKE '%$word%' OR paymode LIKE '%$word%' OR payamt LIKE '%$word%' OR paydate LIKE '%$word%'";
    }

    $query .= implode(' OR ', $conditions);
    $query .= " ORDER BY payment.paydate DESC"; // Add the ORDER BY clause


    $query_run = mysqli_query($con, $query);
    $count = 1;

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $student) {
            ?>
            <tr>
                <td>
                    <?= $count; ?>
                </td>
                <td>
                    <?= $student['paydate']; ?>
                </td>
                <td>
                    <?= $student['payamt']; ?>
                </td>
                <td>
                    <?= $student['paymode']; ?>
                </td>
                <td>
                    <?= $student['fname']; ?>
                    <?= $student['mname']; ?>
                    <?= $student['lname']; ?>
                </td>
                <td>
                    <?= $student['class']; ?>
                </td>
                <td>
                    <a href="student-view.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                        <i class="bx bx-show icon"></i>
                    </a>
                    <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                        <i class="bx bx-edit icon"></i>
                    </a>

                </td>
            </tr>
            <?php
            $count++;
        }
    } else {
        ?>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; color: #ff0000;">No Record Found</td>
        </tr>
        <?php
    }
}
?>