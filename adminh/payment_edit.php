<?php

include "dbcon.php";
include "sidebar.html";
// include "checklogin.php";

if (isset($_GET['payid'])) {

  // Sanitize the input
  $payid = mysqli_real_escape_string($con, $_GET['payid']);
  // Construct your SQL query
  $query = "SELECT * FROM hpayment JOIN hstudents ON hstudents.sid = hpayment.sid
                WHERE payid = '$payid'";

  // Execute the query
  $result = mysqli_query($con, $query);

  if ($result) {
    // Check if there are any matching records
    if (mysqli_num_rows($result) > 0) {
      $payment = mysqli_fetch_assoc($result);

      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HABITUDE - Payment Edit</title>
      </head>

      <body>

        <div class="navbar"
          style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
          <div class="title" style="margin-top: 22px;margin-left: 30px;">
            <span>Students</span>
            <div class="academic-year-filter" style="margin-top:-17px;margin-left:10px;">
              <select name="academic_year" id="academic_year"
                style="width:90px;height:30px;padding:5px;border:none;border-radius:20px;margin-left:70px;margin-top:-30px;">
                <option value="2023-24">2023-24</option>
                <option value="2024-25">2024-25</option>
              </select>
            </div>

          </div>
          <div class="search-bar">
            <input type="search" placeholder="Search Your Student..." id="search" name="search"
              style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:110px;">
          </div>
          <div class="icons" style="margin-left:25px;margin-top:25px;">

            <a href="admission.php"><i class='bx bx-message-square-add icon'></i></a>
            <i class="bx bx-heart icon"></i>
            <i class="bx bx-mail-send icon"></i>
            <i class="bx bx-map icon"></i>
            <i class="bx bx-user icon"></i>
          </div>
          <div class="log-out-btn" style="margin-left:20px;margin-top:20px;">
            <button
              style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
          </div>
        </div>
        <div class="dashboard-contents"
          style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

          <div class="student-card"
            style="position:absolute;width:900px;height:80px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:20px;margin-left:20px;border-radius:10px; ">
            <a href="student-view.php?sid=<?php echo $payment['sid'] ?>" style="text-decoration:none;">
              <span style="display: block; margin-top: 20px;margin-left:20px;">Student Name :
                <?php echo $payment['fname']; ?>
                <?php echo $payment['mname']; ?>
                <?php echo $payment['lname']; ?>
              </span>
            </a>
            <div class="student-class-and-acdyear" style="margin-left:40px;">
              <span style="display: block; margin-top: -23px;margin-left:350px;">Class :
                <?php echo $payment['classAdmitted']; ?>
              </span>
              <span style="display: block; margin-top: -23px;margin-left:470px;">Academic Year :
                <?php echo $payment['acdyear']; ?>
              </span>
            </div>
          </div>

          <div class="title" style="margin-top:130px;">
            <span style="margin-left:30px;">Edit Payment Form</span>
          </div>
          <form action="code.php" method="POST" style="margin-top:5px;">

            <input type="hidden" name="payid" value="<?= $payment['payid']; ?>">
            <input type="hidden" name="sid" value="<?= $payment['sid']; ?>">

            <input type="number" name="payamt" value="<?= $payment['payamt']; ?>" placeholder="Your Amount"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

            <input type="date" name="paydate" value="<?= $payment['paydate']; ?>" id="paydate" placeholder="Your Amount Date"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

            <select name="paymode" placeholder="Your Amount Date"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              <option>
                <?= $payment['paymode']; ?>
              </option>
              <option value="Not Selected">Select Payment Mode</option>
              <option value="Cash">Cash</option>
              <option value="Account">Account</option>
            </select>

            <select name="acdyear" placeholder="Your Amount Date"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              <option value="2023-24">2023-24</option>
              <option value="2022-23">2022-23</option>
              <option value="2024-25">2024-25</option>
            </select>

            <select name="feestitle" placeholder="Select Fees Titile"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              <option value="Tuition Fee">Tuition Fee</option>
              <option value="Registration Fee">Registration Fee</option>
              <option value="Other Fees">Other Fee</option>
            </select>

            <div class="payment-update-btn" style="margin-left:30px;margin-top:25px;margin-bottom:20px;height:300px;">
              <button class="payment-update-btn" id="refreshButton" value="submit" name="edit_payment"
                style="width:280px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;"
                id="refreshButton">Edit Payment</button>
            </div>
          </form>
        </div>








        <script>

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
}
?>