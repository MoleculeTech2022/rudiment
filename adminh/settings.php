<?php
// Include necessary files
include "checklogin.php"; // Check if the user is logged in
include "dbcon.php"; // Include database connection

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}


// Check if 'sid' is set in the URL
  // Sanitize the input

  $query_totalfees = "SELECT SUM(total_fees) AS total_fees FROM acdyear WHERE acdyear = '2023-24'";
  $query_paidfees = "SELECT SUM(payamt) AS payamt FROM payment WHERE acdyear = '2023-24'";

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
  <title>RUDIMENT - Settings</title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
  <!-- Include the sidebar -->
  <?php
  include "sidebar.html";
  ?>

  <!-- Navbar -->
  <div class="navbar" style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
    <div class="title" style="margin-top: 22px;margin-left: 30px;">
      <span>Settings</span>
    </div>
    <div class="search-bar"> <!-- Search bar code -->
      <input type="search" placeholder="Search Anything..." style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:200px;">
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
        <button style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
      </a>
    </div>
  </div>

  <!-- Dashboard Content -->
  <div class="dashboard-contents" style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: 71px;">
<div class="title" style="margin-top:10px;"> 
<span style="margin-left:30px;margin-top:10px;">Change Default Academic Year</span>
</div>
  <form action="code.php" method="POST">
  <?php
  $defaultAcdyear = "SELECT default_acdyear FROM dacdyear";
  $defaultResult = mysqli_query($con,$defaultAcdyear);

  if(mysqli_num_rows($defaultResult) >0){
    while($rows = mysqli_fetch_assoc($defaultResult)){
?>

<select type="text" name="default_acdyear" id="default_acdyear" value="<?php echo $rows['default_acdyear']; ?>" style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
<option value="2023-24">2023-24</option>
<option value="2022-23">2022-23</option>
<option value="2024-25">2024-25</option>
</select>
<?php
    }
  }
  ?>

  <div class="button-default-acdyear" style="margin-top:20px;">
    <button name="set_button" style="width:210px;height:30px;background-color:#fff;border-radius:5px;margin-left:30px;">Set Academic Year</button>
  </div>
</form>
    <!-- End of more cards -->
  </div>
</body>
</html>
