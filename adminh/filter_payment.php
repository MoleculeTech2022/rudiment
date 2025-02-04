<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'dbcon.php';

if (isset($_POST['academic_year'])) {
  $selectedYear = mysqli_real_escape_string($con, $_POST['academic_year']);

  // Use proper table and column names in your SQL query
  $query = "SELECT * FROM payment
            JOIN students ON payment.sid = students.sid
            WHERE acdyear = '$selectedYear'";

  $query_run = mysqli_query($con, $query);

  if ($query_run) {
    if (mysqli_num_rows($query_run) > 0) {
      while ($student = mysqli_fetch_assoc($query_run)) {
        // Output the table rows with the filtered data
        ?>
        <tr>
          <td><?= $student['sid']; ?></td>
          <td><?= $student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname']; ?></td>
          <td><?= $student['acdyear']; ?></td>
          <td><?= $student['payamt']; ?></td>
          <td><?= $student['paydate']; ?></td>
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
      }
    } else {
      echo "<tr><td colspan='6'><h5>No Record Found</h5></td></tr>";
    }
  } else {
    echo "MySQL Error: " . mysqli_error($con);
  }
}
?>
