<?php
require 'dbcon.php';
include "sidebar.html";
// include "checklogin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HABITUDE - Payments</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#search").on("keyup", function () {
        var searchText = $(this).val().toLowerCase();

        $.ajax({
          url: "payhis_search.php", // Create a PHP script for filtering
          method: "POST",
          data: { search: searchText },
          success: function (data) {
            $("#student-table tbody").html(data);
          }
        });
      });
    });
  </script>


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




    .card {
      background-color: #fff;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      padding: 20px;
      text-align: center;
      border-radius: 5px;
    }

    .card h2 {
      margin: 0;
      padding-bottom: 10px;
    }

    .card ul {
      list-style-type: none;
      padding: 0;
    }

    .card li {
      margin-bottom: 10px;
    }

    * {
      /* Change your font family */
      font-family: sans-serif;
    }

    .content-table {
      border-collapse: collapse;
      margin: 25px 0;
      font-size: 0.9em;
      width: 900px;
      border-radius: 5px 5px 0 0;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    .content-table thead tr {
      background-color: aliceblue;
      color: #ffffff;
      text-align: left;
      font-weight: bold;
    }

    .content-table th,
    .content-table td {
      padding: 12px 15px;
    }

    .content-table tbody tr {
      border-bottom: 1px solid #dddddd;
    }

    .content-table tbody tr:nth-of-type(even) {
      background-color: #f3f3f3;
    }

    .content-table tbody tr:last-of-type {
      border-bottom: 2px solid #ffffff;
    }

    .content-table tbody tr.active-row {
      font-weight: bold;
      color: #000000;
    }

    .icon {
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="navbar"
      style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
      <div class="title" style="margin-top: 22px;margin-left: 30px;">
        <span>Payments</span>

        <div class="academic-year-filter" style="margin-top:-23px;margin-left:30px;">
          <select name="academic_year" id="academic_year"
            style="width:90px;height:35px;padding:5px;border:none;border-radius:20px;margin-left:70px;margin-top:-30px;">
            <option value="2023-24">2023-24</option>
            <option value="2024-25">2024-25</option>
          </select>
        </div>

      </div>
      <div class="search-bar">
        <input type="search" placeholder="Search Your Student..." id="search" name="search"
          style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:240px;">
      </div>
      <div class="icons" style="margin-left:25px;margin-top:25px;">


        <a href="../adminr/index.php" style="text-decoration:none;">
          <button
            style="width: 30px; height: 30px; background-color: aliceblue; border-width: 1px; border-radius: 20px; color: #000;">R</button>
        </a>
      </div>
      <div class="log-out-btn" style="margin-left:10px;margin-top:20px;">
        <button
          style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
      </div>
    </div>
    <!-- Main Content of Page  -->
    <div class="dashboard-contents"
      style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">
      <h4 style="margin-left:30px;margin-top:10px;">Fees Payment for Any Student</h4>

      <div class="payment-history-card"
        style="width:500px;height:200px;background-color:aliceblue;margin-left:500px;border-radius:10px;box-shadow:1px 1px 1px 1px #edeaea;">
        <div class="title" style="margin-top:15px;position:absolute;margin-left:15px;">
          <span>Selected Student Details</span>


        </div>

      </div>
      <!-- Select student to make payment  -->
      <div class="select-student-form">
        <form action="code.php" method="POST" style="margin-top:-200px;">

          <div class="searchable-select-box" style="margin-left:30px;">

            <?php
            // Execute a SQL query to select student names from the database
            $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM hstudents");

            // Create a dropdown select element
            echo "<select id='fetch' name='sid' style='height:30px;margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;background-color:#fff;'>";
            echo "<option>Select Student</option>";

            // Loop through the results and populate the select options with student names
            while ($row = mysqli_fetch_array($direct)) {
              echo "<option value='" . $row['sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
            }
            ?>
          </div>

          <input type="number" required name="payamt" placeholder="Your Amount"
            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
          <br>

          <select name="paymode" required placeholder="Your Amount Date"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
            <option value="Not Selected">Select Payment Mode</option>
            <option value="Cash">Cash</option>
            <option value="Account">Account</option>
          </select>

          <select name="acdyear" placeholder="Your Amount Date"
            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
            <option value="2023-24">2023-24</option>
            <option value="2022-23">2022-23</option>
            <option value="2024-25">2024-25</option>
          </select><br>

          <select name="feestitle" placeholder="Select Fees Titile"
            style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
            <option value="Tuition Fee">Tuition Fee</option>
            <option value="Registration Fee">Registration Fee</option>
            <option value="Other Fees">Other Fee</option>
          </select>

          <input type="date" required name="paydate" id="paydate" placeholder="Your Amount Date"
            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


          <div class="payment-update-btn" style="margin-left:0px;margin-top:25px;margin-bottom:20px;height:300px;">

            <button class="payment-update-btn" id="refreshButton" value="submit" name="update_payment"
              style="width:280px;height:35px;border-radius:5px;background-color:#00eaff;border-width:1px;"
              id="refreshButton">Update Payment</button>

            <h4 style="margin-top:10px;">Payment History</h4>

          </div>
        </form>



      </div>


      <table class="content-table" id="student-table" style="margin-left :30px;margin-top:-240px;">
        <thead>
          <tr>
            <th style="color: #000000;">#</th>
            <th style="color: #000000;">Pay Date</th>
            <th style="color: #000000;">Amt</th>
            <th style="color: #000000;">Mode</th>
            <th style="color: #000000;">Student</th>
            <th style="color: #000000;">Class</th>
            <th style="color: #000000;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 0;
          $query = "SELECT * FROM hpayment 
          JOIN hstudents ON hstudents.sid = hpayment.sid 
          JOIN hacdyear ON hstudents.sid = hacdyear.sid 
          ORDER BY hpayment.payid DESC";
          // $query = "SELECT * FROM payment JOIN students on students.sid = payment.sid WHERE payment.sid != '' ORDER BY payment.paydate ASC";
          $query_run = mysqli_query($con, $query);
          // var_dump($query_run);
          if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $student) {
              ?>
              <tr>
                <td>
                  <?= $student['payid']; ?>
                </td>
                <td>
                  <?= $student['paydate']; ?>
                </td>
                <td>
                  <?= $student['payamt']; ?>
                </td>
                <td>
                  <?= $student['paymode']; ?>
                </td>
                <td>
                  <?= $student['fname']; ?>
                  <?= $student['mname']; ?>
                  <?= $student['lname']; ?>
                </td>
                <td>
                  <?= $student['class']; ?>
                </td>
                <td>
                  <a href="payment_due.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                    <i class="bx bx-show icon" style="color:#000;"></i>
                  </a>
                  <!-- // Edit on student list  -->
                  <a href="payment_edit.php?payid=<?= $student['payid']; ?>" style="text-decoration:none;">
                    <i class="bx bx-edit icon" style="color:#000;"></i>
                  </a>


                </td>
              </tr>
              <?php
              $count++;
            }
          } else {
            echo "<h5> No Record Found </h5>";
          }
          ?>

        </tbody>
      </table>

    </div>
  </div>


  <!-- // function updateStudentTable(selectedYear) {
    //       $.ajax({
    //           url: "ayear.php",
    //           method: "POST",
    //           data: { academic_year: selectedYear },
    //           success: function (data) {
    //               $("#student-table tbody").html(data);
    //           },
    //           error: function () {
    //               $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
    //           }
    //       });
    //   } -->

  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

  <!-- Include Chosen CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

  <!-- Include Chosen jQuery plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

  <!-- Initialize Chosen on the 'search' select element -->
  <script>
    // Initialize Chosen on the 'search' select element
    $('#fetch').chosen();
  </script>

  <!-- ajax call script -->
  <script>
    $(document).ready(function () {
      // Initial table load with default academic year
      updateStudentTable("2024-25");
      updateStudentTable("2023-24");

      // Handle academic year change
      $("#academic_year").change(function () {
        var selectedYear = $(this).val();
        updateStudentTable(selectedYear);
      });
    });

    // Add search functionality using jQuery
    // Initialize Select2
    $("#studentSelect").select2();

    // Live search functionality
    $("#studentSelect").select2({
      minimumInputLength: 1,
      ajax: {
        url: "search.php", // Create a separate PHP file for handling AJAX requests
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            q: params.term // Search term entered by the user
          };
        },
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      }
    });

  </script>

  <script>
    function fetchStudentName(studentId) {
      if (studentId) {
        $.ajax({
          url: "livepay.php", // Create a PHP script to fetch the student name
          method: "POST",
          data: { studentId: studentId },
          success: function (data) {
            // Update the student name display div with the fetched name
            $("#StudentNameDiv").html(data);
          }
        });
      }
    }
  </script>

</body>

</html>