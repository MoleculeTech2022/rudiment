<?php
require 'dbcon.php';

// Check if 'sid' is set in the URL
if (isset($_GET['sid'])) {
  // Sanitize the input
  $student_id = mysqli_real_escape_string($con, $_GET['sid']);

  // Construct your SQL query
  $query = "SELECT * FROM students
              JOIN parents ON students.sid = parents.sid
              WHERE students.sid = '$student_id'";

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
        <title>RUDIMENT - New Admission</title>
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

        <div class="dashboard-contents"
          style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: -30px;border-bottom:-60px;">
          <h3 style="text-align:center;margin-left:340px;">Student Details Edit Form</h3>
          <div class="student-admission-form"
            style="border:2px solid #40e0d0;width:900px;margin-left:30px;border-radius:5px;">
            <!-- // Student Details Edit FORM  -->
            <form action="edit.php" method="POST">

              <div class="student-details">
                <div class="title"
                  style="margin-top:20px;width:97%;height:25px;background-color:#40e0d0;padding:10px;margin-left:30px;">
                  <div class="title-2" style="margin-top:-10px;">
                    <span style="margin-left:30px;margin-top:-30px;color:#fff;">Student Details</span>
                  </div>
                </div>

                <input type="hidden" name="sid" value="<?= $student_id; ?>">

                <input type="text" name="fname" value="<?= $student['fname']; ?>" required placeholder="Student First Name"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="text" name="mname" value="<?= $student['mname']; ?>" required placeholder="Student Middle Name"
                  oninput="autoFillFaname()"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                <div class="third-input" style="margin-left:520px;margin-top:-51px;">

                  <input type="text" name="lname" value="<?= $student['lname']; ?>" required placeholder="Student Last Name"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                </div>

                <input type="date" name="dob" value="<?= $student['dob']; ?>" title="Student Date of Birth"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <div class="third-input" style="margin-left:275px;margin-top:-51px;">
                  <select name="gender" placeholder="Student Gender"
                    style="margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                    <option value="<?= $student['gender']; ?>">
                      <?= $student['gender']; ?>
                    </option>
                    <option value="Gender Not Selected">Select Student Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>

                <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                  <input type="text" name="reg_num" placeholder="Student Register No" disabled
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                </div>

                <select name="classAdmitted" title="Class Admitted"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  </option>
                  <option value="<?= $student['classAdmitted']; ?>">
                    <?= $student['classAdmitted']; ?>
                  </option>
                  <option value="Play_Group">Play Group</option>
                  <option value="NUR">Nursery</option>
                  <option value="LKG">LKG</option>
                  <option value="UKG">UKG</option>
                  <option value="Other">Other</option>
                </select>
                <input type="number" name="saadhar" <?= $student['saadhar']; ?> placeholder="Student Aadhar No"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <select name="religion"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  <option value="<?= $student['religion']; ?>">
                    <?= $student['religion']; ?>
                  </option>
                  <option value="Religion not selected">Select Religion</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Muslim">Muslim</option>
                  <option value="Christian">Christian</option>
                  <option value="Buddhist">Buddhist</option>
                  <option value="Sikh">Sikh</option>
                  <option value="Jain">Jain</option>
                  <option value="Other">Other</option>

                </select>
                <br>
                <select name="category" placeholder="Category"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  </option>
                  <option value="<?= $student['category']; ?>">
                    <?= $student['category']; ?>
                  </option>
                  <option value="Category not selected">Select Category</option>
                  <option value="OPEN">OPEN - General</option>
                  <option value="SC">SC</option>
                  <option value="ST">ST</option>
                  <option value="OBC">OBC</option>
                </select>

                <input type="text" name="caste" value="<?= $student['caste']; ?>" placeholder="Student Caste"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="date" name="doa" value="<?= $student['doa']; ?>" title="Date Of Admission" required
                  placeholder="Date Of Admission"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <select name="current_class" title="current_class"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  </option>
                  <option value="<?= $student['current_class']; ?>">
                    <?= $student['current_class']; ?>
                  </option>
                  <option>Current Class</option>
                  <option value="NUR">Nursery</option>
                  <option value="LKG">LKG</option>
                  <option value="UKG">UKG</option>
                  <option value="play_group">Play Group</option>
                </select>

              </div>

              <div class="title"
                style="margin-top:20px;width:97%;height:25px;background-color:#40e0d0;padding:10px;margin-left:30px;">
                <div class="title-2" style="margin-top:-10px;">
                  <span style="margin-left:30px;margin-top:-30px;color:#fff;">Parents Details</span>
                </div>
              </div>

              <div class="parents-details">
                <input type="text" name="faname" id="faname" value="<?= $student['faname']; ?>" required
                  placeholder="Father Name"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="text" name="foccup" value="<?= $student['foccup']; ?>" placeholder="Father Occupation"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                  <input type="number" name="fcontact" minlength="10" value="<?= $student['fcontact']; ?>"
                    placeholder="Father Contact"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                </div>

                <input type="text" name="moname" value="<?= $student['moname']; ?>"  placeholder="Mother Name"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="text" name="moccup" value="<?= $student['moccup']; ?>" placeholder="Mother Occuption"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


                <div class="third-input" style="margin-left:520px;margin-top:-51px;">
                  <input type="number" name="mcontact" value="<?= $student['mcontact']; ?>" minlength="10"
                    placeholder="Mother Contact"
                    style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                </div>

                <input type="text" name="padr" value="<?= $student['padr']; ?>" placeholder="Permanent Address"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="text" name="pdis" value="<?= $student['pdis']; ?>" placeholder="Permanent District"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <input type="text" name="local_addr" value="<?= $student['local_addr']; ?>" placeholder="Local Address"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                <br>

                <select type="text" name="pstate" placeholder="Permanent State"
                  style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                  <option value="<?= $student['pstate']; ?>">
                    <?= $student['pstate']; ?>
                  </option>
                  <option value="Maharashtra">Maharashtra</option>
                  <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                  <option value="Andhra Pradesh">Andhra Pradesh</option>
                  <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                  <option value="Assam">Assam</option>
                  <option value="Bihar">Bihar</option>
                  <option value="Chandigarh">Chandigarh</option>
                  <option value="Chhattisgarh">Chhattisgarh</option>
                  <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                  <option value="Delhi">Delhi (National Capital Territory of Delhi)</option>
                  <option value="Goa">Goa</option>
                  <option value="Gujarat">Gujarat</option>
                  <option value="Haryana">Haryana</option>
                  <option value="Himachal Pradesh">Himachal Pradesh</option>
                  <option value="Jharkhand">Jharkhand</option>
                  <option value="Karnataka">Karnataka</option>
                  <option value="Kerala">Kerala</option>
                  <option value="Ladakh">Ladakh</option>
                  <option value="Lakshadweep">Lakshadweep</option>
                  <option value="Madhya Pradesh">Madhya Pradesh</option>
                  <option value="Manipur">Manipur</option>
                  <option value="Meghalaya">Meghalaya</option>
                  <option value="Mizoram">Mizoram</option>
                  <option value="Nagaland">Nagaland</option>
                  <option value="Odisha">Odisha</option>
                  <option value="Puducherry">Puducherry (Pondicherry)</option>
                  <option value="Punjab">Punjab</option>
                  <option value="Rajasthan">Rajasthan</option>
                  <option value="Sikkim">Sikkim</option>
                  <option value="Tamil Nadu">Tamil Nadu</option>
                  <option value="Telangana">Telangana</option>
                  <option value="Tripura">Tripura</option>
                  <option value="Uttar Pradesh">Uttar Pradesh</option>
                  <option value="Uttarakhand">Uttarakhand</option>
                  <option value="West Bengal">West Bengal</option>
                </select>

              </div>

              <div class="update-student-details-div"
                style="margin-left:30px;margin-top:-18px;margin-bottom:20px;height:300px;">

                <br>
                <a href="student-edit.php?sid=<?= $student_id; ?>">
                  <button class="update-student-details" name="edit_btn" value="submit"
                    style="width:300px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;margin-top:30px;">Update
                    Student Details</button>
                </a>
              </div>

            </form>
          </div>
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