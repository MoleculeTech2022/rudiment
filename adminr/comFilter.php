<?php
include 'dbcon.php';

if (isset($_POST['comStatus'])) {
    $comStatus = $_POST['comStatus'];

    // Modify your SQL query based on the selected comStatus
    $sqlFetchStudents = "SELECT * FROM complaint 
        JOIN students ON students.sid = complaint.sid
        WHERE comStatus = '$comStatus'
        ORDER BY cfid DESC";

    $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);

    if (mysqli_num_rows($resultFetchStudents) > 0) {
        while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {


            $email = $rows['email'];

            $status = $rows['status'];
            $rowClass = '';

            if ($status == 'Solved') {
                $rowClass = 'solved-status';
            } elseif ($status == 'Pending') {
                $rowClass = 'pending-status';
            }
            ?>
            <tr>

                <td><input type="checkbox"></td>
                <td>
                    <?php echo $rows['date']; ?>
                </td>

                <td>
                    <a href="#" class="student-name-link" data-sid="<?php echo $rows['sid']; ?>"
                        style="text-decoration: none;color:#000;">
                        <span style="font-size:15px;">
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
                    <?php echo $rows['comtype']; ?>
                </td>
                <td>
                    <?php
                    $complaint = $rows['complaint'];
                    $words = explode(' ', $complaint);
                    $limitedComplaint = implode(' ', array_slice($words, 0, 3)); // Limiting to 10 words
                    echo $limitedComplaint;

                    echo '...'; // Add an ellipsis if there are more words
                    ?>
                </td>
                <td class="<?php echo $rowClass; ?>">
                    <?php echo $rows['comStatus']; ?>
                </td>

                <td>
                    <a href=" payment_due.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration:none;">
                        <i class="fa fa-ellipsis-v" style="margin-left:15px;"></i>
                    </a>
                    <a href="viewComplaint.php?cfid=<?php echo $rows['cfid']; ?>" style="text-decoration:none;">
                        <i class="fa fa-edit" style="margin-left:15px;"></i>
                    </a>
                    <!-- <a href="student-edit.php?sid=<?php echo $rows['sid']; ?>">
                        <i class="fa fa-camera" style="margin-left:15px;"></i>
                    </a> -->
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='6'><h5>No Record Found</h5></td></tr>";
    }
} else {
    echo "MySQL Error: " . mysqli_error($con);
}

?>