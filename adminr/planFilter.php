<?php
session_start();
require 'dbcon.php';

if (isset($_POST['search'])) {
    $searchText = trim($_POST['search']); // Trim leading and trailing spaces
    $searchWords = explode(' ', $searchText); // Split the input into individual words

    $query = "SELECT * FROM students 
    JOIN feesplan ON students.sid = feesplan.sid
    JOIN parents ON students.sid = parents.sid
     WHERE ";

    $conditions = array();
    foreach ($searchWords as $word) {
        // Search first name, middle name, and last name separately
        $conditions[] = "fname LIKE '%$word%' OR mname LIKE '%$word%' OR lname LIKE '%$word%' OR classAdmitted LIKE '%$word%' OR fcontact LIKE '%$word%' OR mcontact LIKE '%$word%'";
    }

    $query .= implode(' OR ', $conditions);

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
                    <?= $student['fname']; ?>
                    <?= $student['mname']; ?>
                    <?= $student['lname']; ?>
                </td>
                <td>
                    <?= $student['plandate']; ?>
                </td>
                <td>
                    <?= $student['planamt']; ?>
                </td>
                <td>
                    <?= $student['mcontact']; ?>
                </td>

                <td>
                    <a href="plan_edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                        <i class="bx bx-show icon"></i>
                    </a>
                    <a href="plan_edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                        <i class="bx bx-edit icon"></i>
                    </a>
                    <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                        <i class="bx bx-heart icon"></i>
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