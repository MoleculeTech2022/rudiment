<?php
require 'dbcon.php';

// Check if 'sid' is set in the URL
if (isset($_GET['sid'])) {
  // Sanitize the input
  $student_id = mysqli_real_escape_string($con, $_GET['sid']);

  // Construct your SQL query
  $query = "SELECT * FROM students
              JOIN payment ON students.sid = payment.sid
              JOIN parents ON students.sid = parents.sid
              JOIN acdyear ON students.sid = acdyear.sid
              WHERE students.sid = '$student_id'";

  // Execute the query
  $query_run = mysqli_query($con, $query);

  if ($query_run) {
    // Check if there are any matching records
    if (mysqli_num_rows($query_run) > 0) {
      $student = mysqli_fetch_assoc($query_run);

      $sql = "SELECT SUM(payamt) AS total_amount FROM payment WHERE sid = $student_id ";
      $result = mysqli_query($con, $sql);

      if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalAmount = $row["total_amount"];
      } else {
        echo "Error fetching total payment amount: " . mysqli_error($con);
      }
      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student View</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

        <link rel="stylesheet" href="path-to-your-custom-chosen.css">


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
          /* Google Fonts - Poppins */
          @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

          * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
          }

          body {
            min-height: 100%;
            background-color: #f2f4f6;
          }


          /* Custom styles for the Chosen select box container */
          .chosen-container {
            border: 2px solid #ffffff;
            background-color: #f5f5f5;
            color: #000000;
            border-radius: 5px;
            box-shadow: 1px 1px 1px 1px #edeaea;
          }

          /* Custom styles for the Chosen dropdown list */
          .chosen-drop {
            background-color: #fff;
            border: 1px solid #ccc;
          }

          /* Custom styles for the Chosen selected options */
          .chosen-choices {
            border: 1px solid #ccc;
            background-color: #f5f5f5;
          }
        </style>
      </head>

      <body>
        <?php
        include "sidebar.html";
        ?>

        </div>
        <div class="second-navigation"
          style="width:100%;height:40px;background-color:#ffff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:-18px;margin-left:0px;">

          <div class="secondNavContents" style="margin-left:280px;">
            <span>To search another student search student here.</span>

            <div class="searchable-select-box" style="margin-left:420px;margin-top:-28px;">

              <?php
              // Execute a SQL query to select student names from the database
              $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM students");
              echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
              echo "<option>Select Student</option>";
              while ($row = mysqli_fetch_array($direct)) {
                echo "<option value='" . $row['sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
              }
              echo "</select>";
              ?>
            </div>
            <div class="btns" style="margin-top:-33px;margin-left:720px;">

              <a href="payments.php" style="text-decoration:none;">
                <button
                  style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(49, 217, 255);color:#fff;border:none;border-radius: 5px;">Payments</button>
              </a>
              <a href="students.php" style="text-decoration:none;">
                <button
                  style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Back</button>
              </a>
            </div>
          </div>

        </div>

        <div class="student-profile-first-card"
          style="width:950px;height:160px;border-radius:5px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:280px;margin-top:20px;position:absolute;">

          <div class="edit-profile-direct-btn"
            style="width:70px;height:30px;background-color:rgb(225, 225, 249);border-radius:10px;padding:3px;margin-top:10px;margin-left:870px;">
            <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="margin-left:10px;text-decoration:none;">Edit</a>
            <i class="fa fa-pencil" style="margin-left:3px;"></i>
          </div>

          <div class="second-contaner" style="display: flex;">
            <img src="./images/photo.png" style="width:120px;height:120px;margin-top:-25px;margin-left:20px;">

            <div class="student-name-div" style="margin-top:-15px;">
              <h3 style="margin-left:20px;"><?= $student['fname']; ?>       <?= $student['mname']; ?>
                <?= $student['lname']; ?>
              </h3>
              <div class="first-layer-div" style="margin-top:10px;">
                <span style="margin-left: 20px;">Current Class : <?= $student['current_class']; ?></span>
                <span style="margin-left: 20px;">Date Of Birth : <?= $student['dob']; ?></span>
                <span style="margin-left: 20px;">Date Of Admission : <?= $student['doa']; ?></span>
              </div>
              <div class="second-layer-div" style="margin-top:10px;">
                <span style="margin-left: 20px;">Gender : <?= $student['gender']; ?></span>
                <span style="margin-left: 20px;">Mob No : <?= $student['mcontact']; ?></span>
                <span style="margin-left: 20px;">Religion : <?= $student['religion']; ?></span>
                <span style="margin-left: 20px;">Caste : <?= $student['caste']; ?></span>
                <span style="margin-left: 20px;">Catgeory : <?= $student['category']; ?></span>
              </div>
            </div>

            <div class="parents-details-card"
              style="position:absolute;width:300px;height:570px;border-radius:5px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:0px;margin-top:150px;">

              <h4 style="margin-left:20px;margin-top:20px;">Student Parents Details</h4>

              <div class="parents-details" style="margin-top:30px;">
                <span style="margin-left:20px;margin-top:20px;">Father Name :
                  <?php echo $student['faname']; ?>
                </span><br>
                <div class="second-details-layer" style="margin-top:10px;">
                  <span style="margin-left:20px;margin-top:30px;">Father Occupation :
                    <?php echo $student['foccup']; ?>
                  </span><br>
                </div>
                <br>
                <div class="third-details-layer" style="margin-top:10px;">
                  <span style="margin-left:20px;margin-top:30px;">Father Mob :
                    <?php echo $student['fcontact']; ?>
                  </span><br>
                </div>

                <div class="parents-details" style="margin-top:20px;">
                  <span style="margin-left:20px;margin-top:20px;">Mother Name :
                    <?php echo $student['moname']; ?>
                  </span><br>
                  <div class="second-details-layer" style="margin-top:10px;">
                    <span style="margin-left:20px;margin-top:30px;">Mother Occupation :
                      <?php echo $student['moccup']; ?>
                    </span><br>
                  </div>

                  <div class="third-details-layer" style="margin-top:10px;">
                    <span style="margin-left:20px;margin-top:30px;">Mother Mob :
                      <?php echo $student['mcontact']; ?>
                    </span><br>
                  </div>

                  <div class="fourth-details-layer" style="margin-left:20px;margin-top:10px;width:293px;">
                    <span style="margin-left:0px;margin-top:30px;">Per Address :
                      <?php echo $student['padr']; ?>
                    </span><br>
                  </div>

                  <div class="fiffth-details-layer" style="margin-left:20px;margin-top:20px;width:293px;">
                    <span style="margin-left:0px;margin-top:30px;">Per District :
                      <?php echo $student['pdis']; ?>
                    </span><br>
                  </div>

                  <div class="sixth-details-layer" style="margin-left:20px;margin-top:20px;width:293px;">
                    <span style="margin-left:0px;margin-top:30px;">Per State :
                      <?php echo $student['pstate']; ?>
                    </span><br>
                  </div>

                  <div class="seventh-details-layer" style="margin-left:20px;margin-top:20px;width:293px;">
                    <span style="margin-left:0px;margin-top:30px;">Local Address :
                      <?php echo $student['local_addr']; ?>
                    </span><br>
                  </div>

                </div>
              </div>
            </div>

          </div>

          <div class="parents-comments-div"
            style="position:absolute;width:600px;height:300px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:350px;margin-top:390px;">

            <h4 style="margin-left:20px;margin-top:20px;">Payment Timeline</h4>
            <div class="sell-all" style="margin-top:-24px;margin-left:510px;">
              <a href="payment_due.php?sid=<?= $student['sid']; ?>">See All</a>
            </div>
            <?php
            $cssStyles = <<<EOD
<style>
/* CSS styles for payment cards */
.payment-card-container {
}

.payment-card {
    background-color: #f2f4f6;
    padding: 10px;
    border-radius: 5px;
    margin-top:20px;
    width: 575px;
    margin-left:10px; /* Adjust the width as needed */
}

.i-card{

  margin-top:-17px;

}

.payment-amount {
    font-size: 16px;
    margin-bottom: 4px;
    
}

.payment-date,
.payment-mode {
    font-size: 16px;
    margin-top:-26px;
    margin-left:230px;
}

.payment-mode {
  font-size: 16px;
  margin-top:-26px;
  margin-left:190px;
}

.payment-date{

  margin-left:350px;

}

.payment-edit-icon {
    font-size: 24px;
    color: #333;
    margin-left:520px;
    margin-top: -25px;
}
</style>
EOD;

            echo $cssStyles; // Output the CSS styles
      
            // SQL query to fetch comments from the 'comments' table
            $sql_payment = "SELECT * FROM payment WHERE sid = '$student_id' ORDER BY payid DESC  limit 3 ";
            $result = mysqli_query($con, $sql_payment);

            // Check if there are results
            if ($result->num_rows > 0) {

              // Loop through the results and create cards
              while ($row = $result->fetch_assoc()) {
                echo '<div class="payment-card">';
                echo '<div class="payment-amount">Amount : ₹' . $row['payamt'] . '</div>';
                echo '<div class="payment-date">Date : ' . $row['paydate'] . '</div>';
                echo '<div class="payment-mode">Mode : ' . $row['paymode'] . '</div>';
                echo '<div class="i-card">';
                echo '<a href="payment_edit.php?payid=' . $row['payid'] . '">';
                echo '<i class="bx bx-edit payment-edit-icon"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
              }

            } else {
              echo "No comments found.";
            }
            ?>


            <div class="click-here-btn" style="margin-top:10px;">
              <span style="margin-top:10px;margin-left:20px;">There could be more payments. To check</span>
              <a href="payment_due.php?sid=<?= $student['sid']; ?>">
                <span style="margin-top:10px;margin-left:0px;">Click Here</span>
              </a>
            </div>

          </div>

          <div class="student_class_by_academic_year"
            style="position:absolute;width:600px;height:300px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:350px;margin-top:60px;">

            <h4 style="margin-left:20px;margin-top:20px;">Class By Academic Year</h4>

            <div class="edit-profile-direct-btn"
              style="width:170px;height:30px;background-color:rgb(225, 225, 249);border-radius:10px;padding:3px;margin-top:-25px;margin-left:420px;">
              <a href="payment_due.php?sid=<?= $student['sid']; ?>" style="margin-left:10px;text-decoration:none;">
                Payment Details</a>
              <i class="bx bx-credit-card-alt" style="margin-left:3px;"></i>
            </div>

            <?php
            $cssStyles = <<<EOD
<style>
/* CSS styles for payment cards */
.payment-card-container {
}

.payment-card {
    background-color: #f2f4f6;
    padding: 10px;
    border-radius: 5px;
    margin-top:20px;
    width: 575px;
    margin-left:10px; /* Adjust the width as needed */
}

.i-card{

  margin-top:-17px;

}

.payment-amount {
    font-size: 16px;
    margin-bottom: 4px;
    
}

.payment-date,
.payment-mode {
    font-size: 16px;
    margin-top:-26px;
    margin-left:230px;
}

.payment-mode {
  font-size: 16px;
  margin-top:-26px;
  margin-left:190px;
}

.payment-date{

  margin-left:350px;

}

.payment-edit-icon {
    font-size: 24px;
    color: #333;
    margin-left:520px;
    margin-top: -25px;
}
</style>
EOD;

            echo $cssStyles; // Output the CSS styles
      
            // SQL query to fetch comments from the 'comments' table
            $sql_payment = "SELECT * FROM acdyear WHERE sid = '$student_id' ORDER BY aid DESC";
            $result = mysqli_query($con, $sql_payment);

            // Check if there are results
            if ($result->num_rows > 0) {

              // Loop through the results and create cards
              while ($row = $result->fetch_assoc()) {
                echo '<div class="payment-card">';
                echo '<div class="payment-amount">Academic Year : ' . $row['acdyear'] . '</div>';
                echo '<div class="payment-date">Class : ' . $row['class'] . '</div>';
                echo '<div class="total_fees_card" style="margin-top:10px;">Total Fees : ' . $row['total_fees'] . '</div>';
                echo '<div class="i-card">';
                echo '<a href="total_fees_edit.php?aid=' . $row['aid'] . '">';
                echo '<i class="bx bx-edit payment-edit-icon"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
              }

            } else {
              echo "No comments found.";
            }
            ?>

          </div>

        </div>
        <script>
          // Function to redirect to student-view.php with the selected student ID
          function redirectToStudentView(studentID) {
            if (studentID) {
              window.location.href = 'student-view.php?sid=' + studentID;
            }
          }
        </script>

        <script>

          // Function to enable or disable the payamt input field
          function togglePayAmtInput() {
            const payAmtInput = document.getElementById('payamt');
            const paymodeInput = document.getElementById('paymode');
            const paydateInput = document.getElementById('paydate');
            const feestitleInput = document.getElementById('feestitle');
            const acdyearInput = document.getElementById('acdyear');
            const refreshButton = document.getElementById('refreshButton');
            const dueAmount = <?php echo $due; ?>; // Get the due amount from PHP

            // If dueAmount is 0, disable the input; otherwise, enable it
            if (dueAmount === 0) {
              payAmtInput.disabled = true;
              paymodeInput.disabled = true;
              paydateInput.disabled = true;
              feestitleInput.disabled = true;
              acdyear.disabled = true;
              refreshButton.disabled = true;
            } else {
              payAmtInput.disabled = false;
            }
          }

          // Call the function to initially set the input field state
          togglePayAmtInput();

          // Add an event listener to update the input field state if dueAmount changes
          document.addEventListener('DOMContentLoaded', function () {
            const refreshButton = document.getElementById('refreshButton');
            refreshButton.addEventListener('click', togglePayAmtInput);
          });





          // Get a reference to the button element
          const refreshButton = document.getElementById('refreshButton');

          // Add a click event listener to the button
          refreshButton.addEventListener('click', function () {
            // Use location.reload() to refresh the page
            location.reload();
          });

          // Get a reference to the date input field
          const dateInput = document.getElementById('paydate');

          // Add an event listener to format the date when the user changes it
          dateInput.addEventListener('change', function () {
            // Get the selected date from the input
            const selectedDate = dateInput.value;

            // Format the date as desired (e.g., YYYY-MM-DD)
            const formattedDate = formatDate(selectedDate);

            // Update the input field with the formatted date
            dateInput.value = formattedDate;
          });

          // Function to format the date as YYYY-MM-DD
          function formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
          }



        </script>

        <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

        <!-- Include Chosen jQuery plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>


        <!-- Include Chosen CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

        <script>
          $('#fetch').chosen();
        </script>

      </body>

      </html>
      <?php
    } else {
      echo "<h4>No Such ID Found</h4>";
    }
  } else {
    echo "Error: " . mysqli_error($con);
  }

  // Close the database connection
  mysqli_close($con);
} else {
  echo "Student ID not provided in the URL.";
}
?>