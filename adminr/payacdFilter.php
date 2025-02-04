<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'dbcon.php';

if (isset($_POST['academic_year'])) {
    $selectedYear = mysqli_real_escape_string($con, $_POST['academic_year']);

    // Use proper table and column names in your SQL query
    $query = "SELECT * FROM acdyear 
    JOIN students ON acdyear.sid = students.sid
    JOIN payment ON students.sid = payment.sid 
    WHERE acdyear.acdyear = '$selectedYear'
    ORDER BY payment.paydate DESC";

    $query_run = mysqli_query($con, $query);

    $no = 0;
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
                ?>
                <tr>

                    <td>
                        <span style="color:#000;">
                            <?php echo $no + 1; ?>
                        </span>
                    </td>
                    <td>
                        <?php echo $rows['paydate']; ?>
                    </td>

                    <td>
                        <?php echo $rows['payamt']; ?>
                    </td>
                    <td>
                        <?php echo $rows['paymode']; ?>
                    </td>



                    <td>
                        <a href="payment_due.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration: none;color:#000;">
                            <span style="font-size:15px ;">
                                <?php echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?>
                            </span>
                        </a>
                        

                    </td>



                    <td>
                        <a href="payment_due.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration:none;">
                            <i class="fa fa-eye" style="margin-left:15px;"></i>
                        </a>
                        <a href="payment_edit.php?payid=<?php echo $rows['payid']; ?>" style="text-decoration:none;">
                            <i class="fa fa-edit" style="margin-left:15px;"></i>
                        </a>
                    </td>
                </tr>

                <?php
                $no++;
            }
        } else {
            echo "<tr><td colspan='6'><h5>No Record Found</h5></td></tr>";
        }
    } else {
        echo "MySQL Error: " . mysqli_error($con);
    }
}
?>