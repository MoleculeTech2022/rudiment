<?php
// Include necessary files
// include "checklogin.php"; // Check if the user is logged in
include "sidebar.html";
include "dbcon.php"; // Include database connection



$query_totalfees = "SELECT SUM(total_fees) AS total_fees FROM hacdyear WHERE acdyear = '2023-24'";
$query_paidfees = "SELECT SUM(payamt) AS payamt FROM hpayment WHERE acdyear = '2023-24'";

$result = mysqli_query($con, $query_totalfees);
$paid_run = mysqli_query($con, $query_paidfees);

$totalAmount = 0;
$totalpaid = 0;
if ($result && $paid_run) {
  $row = mysqli_fetch_assoc($result);
  $totalAmount = $row["total_fees"];
  // $totalAmount = 735;
  $row1 = mysqli_fetch_assoc($paid_run);
  $totalpaid = $row1["payamt"];
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
  <title>HABITUDE - Admin</title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <!-- Include the sidebar -->


  <!-- Begin of Top Navbar -->
  <div class="navbar"
    style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
    <div class="title" style="margin-top: 22px;margin-left: 30px;">
      <span>Dashboard</span>
    </div>
    <div class="search-bar"> <!-- Search bar code -->
      <input type="search" placeholder="Search Anything..."
        style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:260px;">
    </div>
    <div class="icons" style="margin-left:20px;margin-top:25px;">
      <i class="bx bx-user icon"></i>
    </div>
    <!-- Logout Button  -->
    <div class="log-out-btn" style="margin-left: 10px; margin-top: 20px;">

      <a href="../adminr/index.php" style="text-decoration:none;">
        <button
          style="width: 30px; height: 30px; background-color: aliceblue; border-width: 1px; border-radius: 20px; color: #000;">R</button>
      </a>

      <a href="logout.php">
        <button
          style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
      </a>

    </div>
  </div>
  <!-- End of Top Navbar -->

  <!-- Dashboard Content -->
  <div class="dashboard-contents"
    style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

    <!-- First Card - NEW ADMISSION -->
    <div class="first-add-card"
      style="width: 210px; height: 180px; background-color: #ccc; box-shadow: 1px 1px 1px 1px #edeaea; margin-left: 20px; margin-top: 20px; border-radius: 20px; position: absolute;">
      <div class="new" style="width: 50px; margin-left: 20px; margin-top: 30px;">
        <span style="font-size: 19px;">New Admission</span>
      </div>
      <div class="slogan" style="margin-left: 20px;">
        <span style="font-size: 10px;">Add new student or teacher here.</span>
      </div>
      <div class="add-go-btn">
        <a href="admission.php">
          <button
            style="width: 130px; height: 30px; border-color: black; border-width: 1px; border-radius: 20px; background-color: #4CAF50; color: white; margin-left: 20px; margin-top: 15px;">New
            Admission</button>
        </a>
      </div>
    </div>
    <!-- End of First Card - NEW ADMISSION -->

    <!-- Second Card - STUDENT COUNT -->
    <div class="second-add-card"
      style="width: 210px; height: 180px; background-color: #FFC107; box-shadow: 1px 1px 1px 1px #edeaea; margin-left: 250px; margin-top: 20px; border-radius: 20px; position: absolute;">
      <div class="new" style="width: 150px; margin-left: 20px; margin-top: 30px;">
        <span style="font-size: 19px;">
          <?php
          // Query to get the count of students
          $query = "SELECT COUNT(`sid`) AS count FROM hstudents";
          // Execute the query
          $result = mysqli_query($con, $query);

          if ($result) {
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);

            // Get the count of students
            $count = $row['count'];

            // Display the count
            echo "Total : " . $count;
          } else {
            // Handle query execution error
            // echo "Error: " . mysqli_error($con);
            echo "kya hua";
          }
          ?>
          Student
        </span>
      </div>
      <div class="slogan" style="margin-left: 20px;">
        <span style="font-size: 10px;">All Habitude students manage here.</span>
      </div>
      <div class="add-go-btn">
        <a href="students.php">
          <button
            style="width: 130px; height: 30px; border-color: black; border-width: 1px; border-radius: 20px; background: none; color: #333; margin-left: 20px; margin-top: 15px;">Student</button>
        </a>
      </div>
    </div>
    <!-- End of Second Card - STUDENT COUNT -->

    <!-- Third Card - TEACHERS -->
    <div class="third-add-card"
      style="width: 210px; height: 180px; background-color: #FF5722; box-shadow: 1px 1px 1px 1px #edeaea; margin-left: 20px; margin-top: 220px; border-radius: 20px; position: absolute;">
      <div class="new" style="width: 50px; margin-left: 20px; margin-top: 30px;">
        <span style="font-size: 19px; color: #fff;">10 Teachers</span>
      </div>
      <div class="slogan" style="margin-left: 20px;">
        <span style="font-size: 10px; color: #fff;">All Habitude teachers manage here.</span>
      </div>
      <div class="add-go-btn">
        <button
          style="width: 130px; height: 30px; border-color: #fff; border-width: 1px; border-radius: 20px; background: none; color: #fff; margin-left: 20px; margin-top: 15px;">Teachers</button>
      </div>
    </div>
    <!-- End of Third Card - TEACHERS -->

    <!-- Fourth Card - REPORT -->
    <div class="four-add-card"
      style="width: 210px; height: 180px; background-color: #2196F3; box-shadow: 1px 1px 1px 1px #edeaea; margin-left: 250px; margin-top: 220px; border-radius: 20px; position: absolute;">
      <div class="new" style="width: 50px; margin-left: 20px; margin-top: 30px;">
        <span style="font-size: 19px; color: #fff;">Reports</span>
      </div>
      <div class="slogan" style="margin-left: 20px;">
        <span style="font-size: 10px; color: #fff;">All kinds of reports can be seen here.</span>
      </div>
      <div class="add-go-btn">
        <button
          style="width: 130px; height: 30px; border-color: #fff; border-width: 1px; border-radius: 20px; background: none; color: #fff; margin-left: 20px; margin-top: 15px;">View
          Reports</button>
      </div>
    </div>
    <!-- End of Fourth Card - REPORT -->

    <div class="fees-card"
      style="position:fixed;width:420px;height:170px;background-color:aliceblue;box-shadow:1px 1px 1px 1px #edeaea;margin-left:480px;border-radius:10px;margin-top:20px;">
      <div class="title" style="margin-top:10px;">
        <span style="margin-top:10px;margin-left:20px;">Total Fees Status</span>
      </div>
      <h4 style="margin-left:30px;margin-top:20px;">
        <?php echo $totalAmount ?>
      </h4>
      <div class="title" style="margin-top:5px;">
        <span style="margin-left:30px;">Total Fees</span>

        <h4 style="margin-left:180px;margin-top:-55px;">
          <?php echo $totalpaid ?>
        </h4>
        <div class="title" style="margin-top:5px;">
          <span style="margin-left:180px;">Paid </span>

          <h4 style="margin-left:290px;margin-top:-53px;">
            <?php echo $totalAmount - $totalpaid; ?>
          </h4>
          <div class="title" style="margin-top:5px;">
            <span style="margin-left:290px;">Due</span>
          </div>
          <div class="link" style="margin-left:30px;margin-top:30px;font-size:13px;">
            <span style="color:#000;">To check payment history</span>
            <a href="payments.php">
              <span>click here</span>
            </a>
          </div>
        </div>

        <!-- End of more cards -->
      </div>
    </div>
    <!-- Image slider  -->

</body>

<script>
  let slideIndex = 0;

  function showSlide(n) {
    const slides = document.querySelectorAll('.slider img');
    if (n < 0) {
      slideIndex = slides.length - 1;
    } else if (n >= slides.length) {
      slideIndex = 0;
    }

    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = 'none';
    }

    slides[slideIndex].style.display = 'block';
  }

  function prevSlide() {
    slideIndex--;
    showSlide(slideIndex);
  }

  function nextSlide() {
    slideIndex++;
    showSlide(slideIndex);
  }

  // Initial slide display
  showSlide(slideIndex);
</script>

</html>