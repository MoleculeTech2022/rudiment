<?php
require 'dbcon.php';

// Check if 'sid' is set in the URL
if (isset($_GET['sid'])) {
  // Sanitize the input
  $student_id = mysqli_real_escape_string($con, $_GET['sid']);

  // Construct your SQL query
  $query = "SELECT * FROM hstudents
              JOIN hpayment ON hstudents.sid = hpayment.sid
              JOIN hparents ON hstudents.sid = hparents.sid
              JOIN hacdyear ON hstudents.sid = hacdyear.sid
              WHERE hstudents.sid = '$student_id'";



  // Execute the query
  $query_run = mysqli_query($con, $query);

  if ($query_run) {
    // Check if there are any matching records
    if (mysqli_num_rows($query_run) > 0) {
      $student = mysqli_fetch_assoc($query_run);

      $sql = "SELECT SUM(payamt) AS total_amount FROM hpayment WHERE sid = $student_id ";
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
        <title>HABITUDE - Student View</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
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
            background: #fdfeff;
          }

          nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            padding: 20px 0;
            background-color: #fff;
            box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);
          }

          .logo {
            display: flex;
            align-items: center;
            margin: 0 24px;
          }

          .logo .menu-icon {
            color: #333;
            font-size: 24px;
            margin-right: 14px;
          }

          .logo .logo-name {
            color: #333;
            font-size: 22px;
            font-weight: 500;
          }

          .sidebar-content {
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 16px;
          }

          .list {
            list-style: none;
          }

          .nav-link {
            display: flex;
            align-items: center;
            margin: 8px 0;
            padding: 14px 12px;
            border-radius: 8px;
            text-decoration: none;
          }

          .nav-link:hover {
            background-color: #4070f4;
          }

          .icon {
            margin-right: 14px;
            font-size: 20px;
            color: #707070;
          }

          .link {
            font-size: 16px;
            color: #707070;
            font-weight: 400;
          }

          .nav-link:hover .icon,
          .nav-link:hover .link {
            color: #fff;
          }
        </style>
      </head>

      <body>
        <?php
        include "sidebar.html";
        ?>
        <div class="navbar"
          style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
          <div class="title" style="margin-top: 22px;margin-left: 30px;">
            <span>Student Details</span>
          </div>
          <div class="search-bar">
            <a href="students.php">
              <input type="search" placeholder="Search AnyThing..."
                style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:150px;">
            </a>
          </div>
          <div class="icons" style="margin-left:25px;margin-top:25px;">
            <i class="bx bx-bell icon"></i>
            <i class="bx bx-heart icon"></i>
            <i class="bx bx-mail-send icon"></i>
            <i class="bx bx-map icon"></i>
            <i class="bx bx-user icon"></i>
          </div>
          <div class="log-out-btn" style="margin-left:20px;margin-top:20px;">
            <a href="logout.php">
              <button
                style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
            </a>
          </div>
        </div>
        </div>
        <div class="dashboard-contents"
          style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: 71px;">



          <div class="student-profile-first-card"
            style="width:300px;height:440px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:20px;margin-top:20px;">
            <img src="3176151.png" style="width:120px;height:120px;margin-top:20px;margin-left:80px;">
            <div class="edit-profile-direct-btn">
              <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="margin-left:35px;">Edit Profile</a>
            </div>
            <h4 style="margin-left:35px;margin-top:10px;">
              <?php echo $student['fname']; ?>
              <?php echo $student['mname']; ?>
              <?php echo $student['lname']; ?>
            </h4>

            <div class="another-details" style="margin-top:20px;">
              <span style="margin-left:35px;margin-top:10px;">Class :
                <?php echo $student['classAdmitted']; ?>
              </span>
              <span style="margin-left: 20px;margin-top:10px;">Reg No :
                <?php echo $student['reg_num']; ?>
              </span><br>
            </div>
            <div class="third-details-layer" style="margin-top:10px;">
              <span style="margin-left: 35px;margin-top:20px;">Mob No :
                <?php echo $student['mcontact']; ?>
              </span>
            </div>
            <div class="third-details-layer" style="margin-top:10px;">
              <span style="margin-left: 35px;margin-top:20px;">Date of Birth :
                <?php echo $student['dob']; ?>
              </span>
            </div>
            <div class="fourth-details-layer" style="margin-top:10px;">
              <span style="margin-left: 35px;margin-top:20px;">Admission Date :
                <?php echo $student['doa']; ?>
              </span>
            </div>
            <div class="fifth-details-layer" style="margin-top:10px;">
              <span style="margin-left: 35px;margin-top:20px;">Gender :
                <?php echo $student['gender']; ?>
              </span>
            </div>
            <div class="sixth-details-layer" style="margin-top:10px;">
              <span style="margin-left: 35px;margin-top:20px;">Student Status :
                <?php echo $student['status']; ?>
              </span>
            </div>

          </div>

          <div class="student-payment-details-card"
            style="position:absolute;width:600px;height:440px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:340px;margin-top:-440px;">

            <h4 style="margin-left:20px;margin-top:10px;">Student Payment Details</h4>
            <div class="paid-fees" style="margin-top:20px;">
              <span style="font-size: 30px;margin-left:30px;margin-top:20px;">₹
                <?php echo $totalAmount; ?>
              </span>
              <span style="margin-left:15px;">Paid Fees</span>
            </div>

            <div class="paid-fees" style="margin-top:-45px;">
              <span style="font-size: 30px;margin-left:280px;margin-top:20px;">₹
                <?php echo $student['total_fees']; ?>
              </span>
              <span style="margin-left:15px;">Total Fees</span>
            </div>

            <div class="paid-fees" style="margin-top:20px;">
              <!-- <span style="font-size: 30px;margin-left:30px;margin-top:20px;">₹ ----</span> -->
              <span style="font-size: 30px;margin-left:30px;margin-top:20px;">₹
                <?php
                $due = $student['total_fees'] - $totalAmount;
                echo $due; ?>
              </span>
              <span style="margin-left:15px;">Remaining Fees</span>
              <!-- // php script to check due is zero -->
              <?php
              if ($due == 0) {
                echo "<button style='margin-left:20px;margin-top:10px;width:170px;background-color: #06de2e;border: none;border-radius: 3px;color:#fff;'>Fees Completed All Clear</button>";
                echo '<a href="payment_due.php?sid=' . $student['sid'] . '" style="margin-left:20px;margin-top:10px;width:70px;border: none;border-radius: 3px;"><span>Payment Details</span></a>';
              }
              ?>
            </div>

            <h4 style="margin-left:20px;margin-top:20px;">Make Fees Payment</h4>

            <!-- // Payment Form  -->
            <form action="code.php" method="POST">
              <input type="hidden" name="student_id" value="<?= $student['sid']; ?>">

              <input type="number" name="payamt" id="payamt" placeholder="Your Amount"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <input type="date" name="paydate" id="paydate" placeholder="Your Amount Date"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <select name="paymode" id="paymode" placeholder="Your Amount Date"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <option value="Not Selected">Select Payment Mode</option>
                <option value="Cash">Cash</option>
                <option value="Account">Account</option>
              </select>


              <select name="acdyear" id="acdyear" placeholder="Your Amount Date"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <option value="2023-24">2023-24</option>
                <option value="2022-23">2022-23</option>
                <option value="2024-25">2024-25</option>
              </select>

              <select name="feestitle" id="feestitle" placeholder="Select Fees Titile"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <option value="Tuition Fee">Tuition Fee</option>
                <option value="Registration Fee">Registration Fee</option>
                <option value="Other Fees">Other Fee</option>
              </select>

              <div class="payment-update-btn" style="margin-left:30px;margin-top:25px;margin-bottom:20px;height:300px;">
                <button class="payment-update-btn" id="refreshButton" value="submit" name="update_student"
                  style="width:280px;height:35px;border-radius:5px;background-color:#ffed4e;border-width:1px;"
                  id="refreshButton">Update Payment</button>
              </div>
            </form>

            <div class="parents-details-card"
              style="position:absolute;width:300px;height:370px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:-320px;margin-top:-250px;">

              <h4 style="margin-left:20px;margin-top:20px;">Student Parents Details</h4>

              <div class="parents-details" style="margin-top:30px;">
                <span style="margin-left:20px;margin-top:20px;">Father Name :
                  <?php echo $student['faname']; ?>
                  <?php echo $student['lname']; ?>
                </span><br>
                <div class="second-details-layer" style="margin-top:10px;">
                  <span style="margin-left:20px;margin-top:30px;">Father Occupation :
                    <?php echo $student['foccup']; ?>
                  </span><br>
                </div>

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
                    <span style="margin-left:20px;margin-top:30px;">Mother Mob : ₹
                      <?php echo $student['mcontact']; ?>
                    </span><br>
                  </div>

                  <div class="fourth-details-layer" style="margin-left:20px;margin-top:10px;width:293px;">
                    <span style="margin-left:0px;margin-top:30px;">Address :
                      <?php echo $student['padr']; ?>
                    </span><br>
                  </div>

                </div>
              </div>

              <!-- // parents comments div -->
              <div class="parents-comments-div"
                style="position:absolute;width:600px;height:300px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:320px;margin-top:-330px;">

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
    background-color: #E5E5EA;
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
                $sql_payment = "SELECT * FROM hpayment WHERE sid = '$student_id' limit 3 ";
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

              <!-- // student result div -->
              <div class="student-result-div"
                style="position:absolute;width:600px;height:300px;border-radius:10px;box-shadow:1px 1px 1px 1px #dedddd;margin-left:320px;margin-top:-10px;">



              </div>

            </div>
          </div>
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