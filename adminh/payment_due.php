<?php

include "checklogin.php";
include "dbcon.php";

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

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
        <title>HABITUDE - Payment Due</title>
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
            position: absolute;
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
            <span>Fees Status</span>
          </div>
          <div class="search-bar">
            <input type="search" placeholder="Search AnyThing..."
              style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:200px;">
          </div>
          <div class="icons" style="margin-left:25px;margin-top:25px;">
            <i class="bx bx-bell icon notification"></i>
            <i class="bx bx-heart icon"></i>
            <i class="bx bx-mail-send icon"></i>
            <i class="bx bx-map icon"></i>
            <i class="bx bx-user icon"></i>
          </div>
          <div class2="log-out-btn" style="margin-left:20px;margin-top:20px;">
            <a href="logout.php">
              <button
                style="width:130px;height: 30px;background-color:#fff;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
            </a>
          </div>
        </div>
        <div class="dashboard-contents"
          style="margin-left:261px;width:500px;height:300px;background-color: #ffffff ;position: absolute;margin-top: 71px;">


          <div class="student-card"
            style="position:absolute;width:900px;height:150px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:20px;margin-left:20px;border-radius:10px; ">
            <a href="student-view.php?sid=<?php echo $student_id ?>" style="text-decoration:none;">
              <h4 style="display: block; margin-top: 20px;margin-left:20px;">Student Name :
                <?php echo $student['fname']; ?>
                <?php echo $student['mname']; ?>
                <?php echo $student['lname']; ?>
              </h4>
            </a>
            <span style="display: block; margin-top: 5px;margin-left:20px;">Class :
              <?php echo $student['class']; ?>
            </span>
            <span style="display: block; margin-top: 5px;margin-left:20px;">Academic Year :
              <?php echo $student['acdyear']; ?>
            </span>

            <!-- <a href="payments.php">
            <button style="margin-left:20px;margin-top:10px;width:110px;background-color: #06de2e;border: none;border-radius: 3px;color:#fff;">Make Payment</button>
            </a> -->

            <?php

            $due = $student['total_fees'] - $totalAmount;

            if ($due == 0) {
              echo '<button style="margin-left:20px;margin-top:10px;width:190px;background-color: #06de2e;border: none;border-radius: 3px;color:#fff;">Fees Completed All Clear</button>';
            } else {
              echo '<a href="student-view.php?sid=' . $student["sid"] . '">';
              echo '<button style="margin-left:20px;margin-top:10px;width:110px;background-color:#ffed4e;border:none;border-radius:3px;color:#000;">Make Payment</button>';
              echo '</a>';

            }

            ?>


            <a href="paytimeline.php?payid=<?php echo $student["payid"]; ?>">
              <span>Fees Details</span>
            </a>

            <h1 style="display: block; margin-top: -100px;margin-left:390px;">
              <?php echo $student['total_fees']; ?>
            </h1>
            <span style="margin-left:395px;margin-top:-80px;">Total Fees</span>

            <h1 style="display: block; margin-top: -70px;margin-left:560px;">
              <?php echo $totalAmount; ?>
            </h1>
            <span style="margin-left:560px;margin-top:-80px;">Paid</span>

            <h1 style="display: block; margin-top: -70px;margin-left:690px;">
              <?php echo $due; ?>
            </h1>
            <span style="margin-left:690px;margin-top:-80px;">Due</span>
          </div>
          <?php

    }
  } else {
    echo "No payments found.";
  }
  ?>

      <div class="payment-timeline-div" style="margin-top:190px;margin-left:20px;">

        <h4 style="margin-left:20px;margin-top:-10px;">Payment Timeline</h4>

        <?php
        $cssStyles = <<<EOD
<style>
    /* Your CSS styles go here */
    .card {
        background-color: #E5E5EA;
        padding: 10px;
        width:890px;
        margin: 10px;
        border-radius: 5px;
        margin-top:3px;
    }

    .paydate {
        font-size: 16px;
        margin-right:260px;
        margin-left:390px;
        margin-top:-23px;

    }

    .timestamp {
        font-size: 12px;
        color: #888;
    }

    .payamt {
        margin-top: 0px;
        width:300px;
        margin-right:750px; /* Add space between cdate and comment */
    }
    .paymode {
      margin-top: -24px;
      margin-left: 230px; /* Add space between cdate and comment */
  }

    /* Style the icon */
    .payment-edit-icon {
      font-size:23px;
        color: #333;
        margin-left:550px;
    }

    .editicon{
      margin-top:-23px;
      margin-left:260px;
    }

    .camera-icon{
font-size:23px;
color: #333;
margin-left:500px;
}

.camera{
  margin-top:-30px;
}

</style>
EOD;

        echo $cssStyles; // Output the CSS styles
// SQL query to fetch payment information for the selected student
      
        $sql = "SELECT * FROM hpayment WHERE sid = ' $student_id'";

        $query_run = mysqli_query($con, $sql);

        if (mysqli_num_rows($query_run) > 0) {
          foreach ($query_run as $student) {
            // var_dump($student);
            echo '<div class="card">';
            echo '<div class="payamt">Amount : <span>' . $student['payamt'] . '</span></div>';
            echo '<div class="paymode">Mode : <span>' . $student['paymode'] . '</span></div>';
            echo '<div class="paydate"> Date : <span>' . $student['paydate'] . '</span></div>';
            echo '<div class="editicon">';
            echo '<a href="paymentReceipt.php?payid=' . $student['payid'] . '">';
            echo '<i class="bx bxs-camera camera-icon"></i>';
            echo '</a>';
            echo '<div class="camera">';
            echo '<a href="payment_edit.php?payid=' . $student['payid'] . '">';
            echo '<i class="bx bx-edit payment-edit-icon"></i>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

          }
        } else {
          echo "No payments found.";
        }
        ?>

      </div>
    </div>




  </body>

  </html>
  <?php
} else {
  echo "<h4>No Such ID Found</h4>";
}



?>