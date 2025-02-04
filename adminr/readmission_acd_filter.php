<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'dbcon.php';

if (isset($_POST['academic_year'])) {
    $selectedYear = mysqli_real_escape_string($con, $_POST['academic_year']);

    if ($selectedYear == "all") {

        // Use proper table and column names in your SQL query
        $query = "SELECT * FROM acdyear 
    JOIN students ON acdyear.sid = students.sid
    JOIN parents ON students.sid = parents.sid 
    ORDER BY students.doa DESC";

    } else {

        // Use proper table and column names in your SQL query
        $query = "SELECT * FROM acdyear 
            JOIN students ON acdyear.sid = students.sid
            JOIN parents ON students.sid = parents.sid 
            WHERE acdyear = '$selectedYear'
            ORDER BY students.doa DESC";

    }

    $query_run = mysqli_query($con, $query);

    $count = 0;
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


                    <td style="color:#000;">
                        <?php
                        echo $count + 1;
                        ?>
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
                        <?php echo $rows['current_class']; ?>
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
                        <a href="readmission_view.php?sid=<?= $rows['sid']; ?>">
                            <button style="width:70px;height:55px;border-radius:10px;">View</button>
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