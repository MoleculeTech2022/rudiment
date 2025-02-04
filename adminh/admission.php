<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HABITUDE - New Admission</title>
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
      <span>New Admission</span>
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
          style="width:130px;height: 30px;background-color:#fff;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
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

        <input type="text" name="fname" placeholder="Student First Name"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <input type="text" name="mname" placeholder="Student Middle Name"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
        <div class="third-input" style="margin-left:520px;margin-top:-51px;">

          <input type="text" name="lname" placeholder="Student Last Name"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
        </div>

        <input type="date" name="dob" title="Student Date of Birth"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <input type="date" name="doa" placeholder="Student Academic Year"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <div class="third-input" style="margin-left:520px;margin-top:-51px;">
          <input type="text" name="reg_num" placeholder="Student Register No"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
        </div>

        <select name="classAdmitted" placeholder="Student Student Class"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
          << /option>
            <option value="class not selected">Select Student Class</option>
            <option value="1st">1st</option>
            <option value="2nd">2nd</option>
            <option value="3rd">3rd</option>
            <option value="4th">4th</option>
            <!-- <option value="class 1">Class 1</option>
        <option value="class 2">Class 2</option>
        <option value="class 3">Class 3</option>
        <option value="class 4">Class 4</option> -->
        </select>
        <input type="number" name="saadhar" placeholder="Student Aadhar No"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <div class="third-inp ut" style="margin-left:520px;margin-top:-51px;">
          <select type="gender" name="gender" placeholder="Student Register No"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
            <option value="Gender Not Selected">Select Student Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>

        </div>
      </div>

      <div class="title" style="margin-top:20px;">
        <span style="margin-left:30px;">Parents Details</span>
      </div>

      <div class="parents-details">
        <input type="text" name="faname" placeholder="Father Name"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <input type="text" name="foccup" placeholder="Father Occupation"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <div class="third-input" style="margin-left:520px;margin-top:-51px;">
          <input type="number" minlength="10" name="fcontact" placeholder="Father Contact"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
        </div>

        <input type="text" name="moname" placeholder="Mother Name"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <input type="text" name="moccup" placeholder="Mother Occuption"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


        <div class="third-input" style="margin-left:520px;margin-top:-51px;">
          <input type="number" name="mcontact" minlength="10" placeholder="Mother Contact"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
        </div>

        <input type="text" name="padr" placeholder="Permanent Address"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <input type="text" name="pdis" placeholder="Permanent District"
          style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
      </div>

      <div class="title" style="margin-top:20px;">
        <span style="margin-left:30px;">Payment Details</span>
      </div>

      <div class="update-student-details-div" style="margin-left:30px;margin-top:15px;margin-bottom:20px;height:300px;">

        <input type="number" name="total_fees" placeholder="Total Fees" title="Total Fees"
          style="margin-left:0px;margin-top:10px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


        <select name="acdyear" id="acdyear" placeholder="Your Amount Date"
          style="margin-left:20px;margin-top:-20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
          <option value="2023-24">2023-24</option>
          <option value="2022-23">2022-23</option>
          <option value="2024-25">2024-25</option>
        </select>

        <select name="paymode" placeholder="feesplan"
          style="margin-left:0px;margin-top:20px;padding:5px;width:490px;border-radius:5px;border-width:1px;">
          <option value="Not Selected">Select Mode</option>
          <option value="Cash">Cash</option>
          <option value="Account">Account</option>
        </select>

        <input type="number" name="payamt" placeholder="Pay Amount"
          style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

        <button class="add_student" name="add_button" value="submit"
          style="width:280px;height:35px;border-radius:5px;background-color:#63ffb4;border-width:1px;margin-top:30px;">Enroll
          Student</button>
      </div>

    </form>

  </div>
</body>

</html>