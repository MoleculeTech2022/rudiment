<?php
include 'dbcon.php';
include 'sidebar.html';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee</title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <!-- Begin of Top Navbar -->
  <div class="navbar"
    style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
    <div class="title" style="margin-top: 22px;margin-left: 30px;">
      <span>Employee</span>
    </div>
    <div class="search-bar"> <!-- Search bar code -->
      <input type="search" id="employee-search" placeholder="Search Anything..."
        style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:200px;">
    </div>
    <div class="icons" style="margin-left:25px;margin-top:25px;">
      <i class="bx bx-bell icon notification"></i>
      <i class="bx bx-heart icon"></i>
      <i class="bx bx-mail-send icon"></i>
      <i class="bx bx-map icon"></i>
      <i class="bx bx-user icon"></i>
    </div>
    <!-- Logout Button  -->
    <div class="log-out-btn" style="margin-left: 20px; margin-top: 20px;">
      <a href="logout.php">
        <button
          style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
      </a>
    </div>
  </div>
  <!-- End of Top Navbar -->
  <div class="teachers-contents"
    style="position: absolute; left: 261px; width: 500px; height: 400px; background-color: #ffffff; margin-top: 71px;">

    <div class="teacher-setting"
      style="position:absolute;width:900px;height:50px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius:10px;margin-left:30px;margin-top:20px;">
      <div class="title" style="margin-top:10px;">
        <span style="margin-left:20px;">Employee List</span>
        <!-- <button
          style="margin-left:20px;margin-top:10px;width:110px;background-color: #ded006;border: none;border-radius: 3px;color:#fff;">Update
          Employee</button> -->
        <a href="employee_add.php"><button
            style="margin-left:20px;margin-top:10px;width:110px;background-color: #069dde;border: none;border-radius: 3px;color:#fff;">ADD
            Employee</button></a>
      </div>
    </div>

    <div class="teacher-list" style="margin-top:90px;">
      <?php
      $sqlEmployee = "SELECT * FROM employee";
      $employeeResult = mysqli_query($con, $sqlEmployee);
      if (mysqli_num_rows($employeeResult) > 0) {
        while ($rows = mysqli_fetch_assoc($employeeResult)) {
          ?>
          <div class="employee-card search-result"
            style="width:540px;height:80px;background-color:#fff;box-shadow: 1px 1px 1px 1px #edeaea;border-radius:10px;margin-top:20px;margin-left:30px;">

            <img src="3176151.png" style="width:50px;height:50px;margin-left:10px;margin-top:13px;">
            <div class="name" style="margin-top:-55px;margin-left:80px;">
              <span>Name :
                <?php echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?>
              </span><br>
              <div class="phone" style="margin-top:5px;">
                <span>Contact :
                  <?php echo $rows['contact'] ?>
                </span>
              </div>
              <div class="icons" style="margin-top:-35px;margin-left:360px;">
                <i class="bx bx-show icon"></i>
                <i class="bx bx-edit icon"></i>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>

    <!-- <div class="leave-teachers-card"
      style="width:330px;height:490px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius:10px;margin-left:600px;margin-top:-480px;position:absolute;">
      <div class="title" style="margin-top:15px;margin-left:20px;">
        <span style="margin-top:10px;">On Leave Teachers</span>
      </div>
    </div> -->

    <div class="leave-teachers-card"
      style="width:330px; height:490px; background-color:#fff; box-shadow:1px 1px 1px 1px #edeaea; border-radius:10px; position: fixed; top: 150px; right: 10px; z-index: 999;margin-right:80px;">
      <div class="title" style="margin-top:15px; margin-left:20px;">
        <span style="margin-top:10px;">On Leave Employee</span>
      </div>
    </div>


  </div>


  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('employee-search');
      const teacherCards = document.querySelectorAll('.search-result');

      searchInput.addEventListener('input', function () {
        const searchValue = searchInput.value.trim().toLowerCase();

        teacherCards.forEach((card) => {
          const teacherName = card.querySelector('.name span').textContent.toLowerCase();
          const teacherContact = card.querySelector('.phone span').textContent.toLowerCase();

          if (teacherName.includes(searchValue) || teacherContact.includes(searchValue)) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  </script>

</body>

</html>