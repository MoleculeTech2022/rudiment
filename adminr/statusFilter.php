<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'dbcon.php';

if (isset($_POST['status'])) {
    $selectedStatus = mysqli_real_escape_string($con, $_POST['status']);

    // Use proper table and column names in your SQL query
    $query = "SELECT * FROM students 
    JOIN parents ON students.sid = parents.sid 
    WHERE LOWER(students.status) = LOWER('$selectedStatus')
    ORDER BY students.doa DESC";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            while ($rows = mysqli_fetch_assoc($query_run)) {

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
                $count = 0;
                ?>
                <tr>
                    <td>
                        <?php echo $count + 1 ?>
                    </td>
                    <td>

                        <a href="student-view.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration: none;color:#000;">
                            <span style="font-size:15px ;">
                                <?php echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?>
                            </span>
                        </a>
                        <br>
                        <span style="font-size:10px;">
                            <?php
                            if ($email == '') {
                                echo $rows['fname'] . "@gmail.com";
                            } else {
                                echo $email;
                            } ?>
                        </span>
                    </td>
                    <td>
                        <?php echo $rows['classAdmitted']; ?>
                    </td>
                    <td>
                        <?php echo $rows['doa']; ?>
                    </td>
                    <td>
                        <?php echo $rows['mcontact']; ?>
                    </td>
                    <td class="<?php echo $rowClass; ?>">
                        <?php echo $status; ?>
                    </td>
                    <td>
                        <a href="student-view.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration:none;">
                            <i class="bx bx-id-card" style="margin-left:15px;"></i>
                        </a>
                        <a href="student-edit.php?sid=<?php echo $rows['sid']; ?>">
                            <i class="fa fa-edit" style="margin-left:15px;"></i>
                        </a>
                    </td>
                </tr>
                <?php
                $count++;
            }
        } else {
            echo "<tr><td colspan='6'><h5>No Record Found</h5></td></tr>";
        }
    } else {
        echo "MySQL Error: " . mysqli_error($con);
    }
}
?>