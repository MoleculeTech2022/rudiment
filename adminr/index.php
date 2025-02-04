<?php
// Include necessary files
// include "checklogin.php"; // Check if the user is logged in
include "dbcon.php"; // Include database connection

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
  <title>RUDIMENT - Admin</title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">


</head>

<body style="background-color: #f2f4f6;">
  <!-- Include the sidebar -->
  <?php
  include "sidebar.html";
  ?>

  <!-- Begin of Top Navbar -->

  </div>
  <!-- End of Top Navbar -->

  <!-- Dashboard Content -->
  <?php
  if ($_SESSION['role'] == 1) {
    ?>
    <div class="dashboard-contents"
      style="margin-left:261px;width:500px;height:400px;background-color: #f2f4f6 ;position: absolute;margin-top: -50px;">

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
            $sqlHabitude = "SELECT sum(total_fees) AS totalHabitude FROM hacdyear";
            $resultHabitude = mysqli_query($con, $sqlHabitude);
            if (mysqli_num_rows($resultHabitude) > 0) {
              while ($rows = mysqli_fetch_assoc($resultHabitude)) {

                $totalHabitude = $rows['totalHabitude'];

                $sqlPaidHab = "SELECT sum(payamt) AS totalPaidHab FROM hpayment";
                $resultPaidHab = mysqli_query($con, $sqlPaidHab);
                if (mysqli_num_rows($resultPaidHab) > 0) {
                  while ($rows = mysqli_fetch_assoc($resultPaidHab)) {

                    $totalPaidHab = $rows['totalPaidHab'];

                    ?>

                    <?php
                    // Query to get the count of students
                    // $query = "SELECT COUNT(`sid`) AS count FROM students";
                    $query = "SELECT COUNT(s.sid) AS count FROM students s JOIN acdyear a ON s.sid = a.sid WHERE acdyear = '2024-25'";

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
                      echo "Error: " . mysqli_error($con);
                      
                    }

                    $totalFeesAmount = $totalAmount + $totalHabitude;
                    $totalPaidAmount = $totalpaid + $totalPaidHab;

                    ?>
                    Student
                  </span>
                </div>
                <div class="slogan" style="margin-left: 20px;">
                  <span style="font-size: 10px;">All Rudiment students manage here.</span>
                </div>
                <div class="add-go-btn">
                  <a href="students.php">
                    <button
                      style="width: 130px; height: 30px; border-color: black; border-width: 1px; border-radius: 20px; background-color: #FF5722; color: #333; margin-left: 20px; margin-top: 15px;">Student</button>
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
                  <span style="font-size: 10px; color: #fff;">All Rudiment teachers manage here.</span>
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
                  <span style="font-size: 19px; color: #fff;">
                    
                  
                  
                  <?php
                    // Query to get the count of students
                    // $query = "SELECT COUNT(`sid`) AS count FROM students";
                    $query = "SELECT SUM(total_fees) AS totalFees FROM students s JOIN acdyear a ON s.sid = a.sid WHERE acdyear = '2024-25'";

                    // Execute the query
                    $result = mysqli_query($con, $query);

                    if ($result) {
                      // Fetch the result as an associative array
                      $row = mysqli_fetch_assoc($result);

                      // Get the count of students
                      $count = $row['totalfees'];

                      // Display the count
                      echo "Total : " . $count;
                    } else {
                      // Handle query execution error
                      echo "Error: " . mysqli_error($con);
                      
                    }

                    $totalFeesAmount = $totalAmount + $totalHabitude;
                    $totalPaidAmount = $totalpaid + $totalPaidHab;

                    ?>
                  
                  
                  
                  Reports</span>
                </div>
                <div class="slogan" style="margin-left: 20px;">
                  <span style="font-size: 10px; color: #fff;">All kinds of reports can be seen here.</span>
                </div>
                <div class="add-go-btn">
                  <a href="report.php">
                    <button
                      style="width: 130px; height: 30px; border-color: #fff; border-width: 1px; border-radius: 20px; background: none; color: #fff; margin-left: 20px; margin-top: 15px;">View
                      Reports</button>
                  </a>
                </div>
              </div>
              <!-- End of Fourth Card - REPORT -->
              <!-- // fees card -->
              <div class="fees-card"
                style="position:fixed;width:420px;height:380px;background-color:aliceblue;box-shadow:1px 1px 1px 1px #edeaea;margin-left:480px;border-radius:10px;margin-top:20px;">
                <div style="height: 400px;">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- // php query for doughnut -->
<?php

// play group student select query
$select_play_group_student = "SELECT COUNT(current_class) AS total_play_group_student FROM students WHERE current_class = 'Play Group'";
$select_play_group_student_run = mysqli_query($con,$select_play_group_student);
if(mysqli_num_rows($select_play_group_student_run)>0){
  while($total_play_group_student_rows = mysqli_fetch_assoc($select_play_group_student_run)){
    
    $total_play_group_student = $total_play_group_student_rows['total_play_group_student'];
    
    // nur student select query
$select_nur_student = "SELECT COUNT(current_class) AS total_nur_student FROM students WHERE current_class = 'nur'";
$select_nur_student_run = mysqli_query($con,$select_nur_student);
if(mysqli_num_rows($select_nur_student_run)>0){
  while($total_nur_student_rows = mysqli_fetch_assoc($select_nur_student_run)){
    
    $total_nur_student = $total_nur_student_rows['total_nur_student'];
    
    
    // lkg student select query
    $select_lkg_student = "SELECT COUNT(current_class) AS total_lkg_student FROM students WHERE current_class = 'lkg'";
    $select_lkg_student_run = mysqli_query($con,$select_lkg_student);
    if(mysqli_num_rows($select_lkg_student_run)>0){
      while($total_lkg_student_rows = mysqli_fetch_assoc($select_lkg_student_run)){
        
        $total_lkg_student = $total_lkg_student_rows['total_lkg_student'];
        
        
        // ukg student select query
        $ukg_student = "SELECT COUNT(current_class) AS ukg_student FROM students WHERE current_class = 'ukg'";
        $ukg_student_run = mysqli_query($con,$ukg_student);
        if(mysqli_num_rows($ukg_student_run)>0){
          while($ukg_student_rows = mysqli_fetch_assoc($ukg_student_run)){
            
            $ukg_student = $ukg_student_rows['ukg_student'];
            
            ?>


<script>

const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Play Group','NUR', 'LKG', 'UKG'],
      datasets: [{
        label: 'No. of Students',
        data: [
          <?= $total_play_group_student; ?>,
          <?= $total_nur_student; ?>,
          <?= $total_lkg_student; ?>,
          <?= $ukg_student; ?>
          ],
        borderWidth: 1
      }]
    },
    options: {
    }
  });
  </script>

  <?php 

// select student nur student query lopp brackets close
  }
}

// select student ukg student query lopp brackets close
 }
}

// select student lkg student query lopp brackets close
 }
}

   // select student play group student query lopp brackets close
 }
}
?>

                        </div>
                        
                        <?php
                  }
                }
                ?>

<!-- End of more cards -->
</div>
</div>
<!-- Image slider  -->

</div>

              <?php
              }
            }
  } else {
    ?>
          <!--   -->
         
          <?php
  }
  ?>


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