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
      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HABITUDE - Student Edit</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
        <style>
          .enroll-btn:hover {
            background-color: #dddd;
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
            <span>Student Edit</span>
          </div>
          <div class="search-bar">
            <a href="students.php">
              <input type="search" placeholder="Search AnyThing..."
                style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:168px;">
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


          <!-- // Student Details Edit FORM  -->
          <form action="code.php" method="POST">

            <div class="student-details">
              <div class="title" style="margin-top:20px;">
                <span style="margin-left:30px;">Student Details</span>
              </div>
              <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

              <input type="text" name="fname" value="<?php echo $student['fname']; ?>" placeholder="Student First Name"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <input type="text" name="mname" value="<?php echo $student['mname']; ?>" placeholder="Student Middle Name"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              <div class="third-input" style="margin-left:520px;margin-top:-51px;">

                <input type="text" name="lname" value="<?php echo $student['lname']; ?>" placeholder="Student Last Name"
                  style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              </div>

              <input type="date" name="dob" value="<?php echo $student['dob']; ?>" title="Student Date of Birth"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">



              <select name="acdyear" placeholder="Student Academic Year"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <option value="academic year not selected">Select Academic Year</option>
                <option value="<?php echo $student['acdyear']; ?>"></option>
                <option value="2022-23">2022-23</option>
                <option value="2023-24">2023-24</option>
              </select>

              <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                <input type="text" name="reg_num" value="<?php echo $student['reg_num']; ?>" placeholder="Student Register No"
                  style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              </div>

              <select name="classAdmitted" placeholder="Student Student Class"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                << /option>
                  <option value="<?php echo $student['classAdmitted']; ?>">Select Student Class</option>
                  <option value="class not selected">Select Student Class</option>
                  <option value="nursery">Nursery</option>
                  <option value="lkg">LKG</option>
                  <option value="ukg">UKG</option>
                  <!-- <option value="class 1">Class 1</option>
        <option value="class 2">Class 2</option>
        <option value="class 3">Class 3</option>
        <option value="class 4">Class 4</option> -->
              </select>
              <input type="number" name="saadhar" value="<?php echo $student['saadhar']; ?>" placeholder="Student Aadhar No"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                <input type="date" name="doa" value="<?php echo $student['doa']; ?>" placeholder="Student Register No"
                  style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              </div>

            </div>

            <div class="title" style="margin-top:20px;">
              <span style="margin-left:30px;">Parents Details</span>
            </div>

            <div class="parents-details">
              <input type="text" name="faname" value="<?php echo $student['faname']; ?>" placeholder="Father Name"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <input type="text" name="foccup" value="<?php echo $student['foccup']; ?>" placeholder="Father Occupation"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                <input type="number" minlength="10" value="<?php echo $student['fcontact']; ?>" name="fcontact"
                  placeholder="Father Contact"
                  style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              </div>

              <input type="text" name="moname" value="<?php echo $student['moname']; ?>" placeholder="Mother Name"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <input type="text" name="moccup" value="<?php echo $student['moccup']; ?>" placeholder="Mother Occuption"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


              <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                <input type="number" name="mcontact" value="<?php echo $student['mcontact']; ?>" minlength="10"
                  placeholder="Mother Contact"
                  style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
              </div>

              <input type="text" name="padr" value="<?php echo $student['padr']; ?>" placeholder="Permanent Address"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

              <input type="text" name="pdis" value="<?php echo $student['pdis']; ?>" placeholder="Permanent District"
                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
            </div>

            <div class="title" style="margin-top:20px;">
              <span style="margin-left:30px;">Academic and Fees Updates</span>
            </div>

            <input type="text" name="total_fees" value="<?php echo $student['total_fees']; ?>" placeholder="Total Fees"
              title="Total Fees"
              style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">



            <div class="update-student-details-div" style="margin-left:30px;margin-top:25px;margin-bottom:20px;height:300px;">

              <button class="update-student-details" name="edit_student_details" value="submit"
                style="width:280px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;">Update
                Student</button>
            </div>


          </form>


        </div>
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