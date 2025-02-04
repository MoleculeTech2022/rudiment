<?php
include "dbcon.php";
include "sidebar.html";


// SQL query to count students
$count = "SELECT COUNT(*) AS student_count FROM students";
$ukg = "SELECT COUNT(*) AS ukg_count FROM students WHERE classAdmitted = 'UKG'";
$lkg = "SELECT COUNT(*) AS lkg_count FROM students WHERE classAdmitted = 'LKG'";
$nur = "SELECT COUNT(*) AS nur_count FROM students WHERE classAdmitted = 'NUR'";
$male = "SELECT COUNT(gender) AS male_count FROM students WHERE gender = 'male'";
$female = "SELECT COUNT(*) AS female_count FROM students WHERE gender = 'female'";


// Execute the query's
$count_run = mysqli_query($con, $count);
$ukg_run = mysqli_query($con, $ukg);
$lkg_run = mysqli_query($con, $lkg);
$nur_run = mysqli_query($con, $nur);
$male_run = mysqli_query($con, $male);
$female_run = mysqli_query($con, $female);

// Check if the query was successful
if ($count_run) {
  // Fetch the count
  $row = mysqli_fetch_assoc($count_run);
  $studentCount = $row['student_count'];

  // Check if the ukg query was successful
  if ($ukg_run) {
    // Fetch the ukg count
    $row1 = mysqli_fetch_assoc($ukg_run);
    $ukgCount = $row1['ukg_count'];

    if ($lkg_run) {
      // Fetch the ukg count
      $row2 = mysqli_fetch_assoc($lkg_run);
      $lkgCount = $row2['lkg_count'];

      if ($nur_run) {
        // Fetch the ukg count
        $row3 = mysqli_fetch_assoc($nur_run);
        $nurCount = $row3['nur_count'];

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>RUDIMENT - Payments</title>

          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>
            $(document).ready(function () {
              $("#search").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                  url: "paymentFilter.php",
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
            /* Styles for the modal */
            .modal {
              display: none;
              position: fixed;
              z-index: 1;
              left: 0;
              top: 0;
              width: 100%;
              height: 100%;
              overflow: auto;
              background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
              background-color: #fff;
              margin: 10% auto;
              margin-top: 30px;
              padding: 20px;
              border: 1px solid #888;
              width: 600px;
              height: 500px;
              border-radius: 5px;
            }

            .close {
              position: absolute;
              right: 0;
              top: 0;
              padding: 10px;
              cursor: pointer;
            }

            table {
              border-collapse: collapse;
              width: 850px;
              margin-left: 30px;
              margin: 20px 0;
            }

            table,
            th,
            td {
              border: none;
            }

            th,
            td {
              text-align: left;
              padding: 8px;
            }

            tr:nth-child(even) {
              background-color: #f2f2f2;
            }

            th {
              background-color: #ffffff;
              color: rgb(0, 0, 0);
            }

            .menu {
              position: absolute;
              background-color: #fff;
              border: 1px solid #ccc;
              box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
              z-index: 1;
            }

            .menu ul {
              list-style-type: none;
              padding: 0;
              margin: 0;
            }

            .menu li {
              padding: 10px;
              cursor: pointer;
            }

            .menu li:hover {
              background-color: #f2f2f2;
            }

            .active-status {
              color: rgb(4, 218, 32);
            }

            .pending-status {
              color: #eea435;
            }

            .suspended-status {
              color: rgb(255, 0, 0);
            }
          </style>

        </head>

        <body style="background-color: #f2f4f6;">
          <div class="container">

            <div class="students-page-contents" style="margin-top:-20px;">
              <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Payments</span><br>
              <span style="font-size:35px;margin-left:290px;margin-top:20px;">Payments</span><br>
              <span style="margin-left:290px;margin-top:20px;font-size: 12px;">All Rudiment payments manage here.</span>

            </div>
            <div class="buttons" style="margin-left:990px;margin-top:-90px;">
              <a href="addPayment.php" style="text-decoration:none;">
                <button id="addPaymentButton"
                  style="height:40px;width:100px;margin-top:20px;margin-left:20px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                  Payment</button>
              </a>
              <a href="students.php">
                <button
                  style="height:40px;width:100px;margin-top:20px;margin-left:10px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">Students</button>
              </a>
            </div>
            <div class="search" style="margin-top: 53px;margin-left:290px;">
              <input type="text" placeholder="search..." name="search" id="search"
                style="width: 250px; height: 35px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
            </div>

            <div class="filter-select-box" style="margin-top: -36px; margin-left: 560px;">
              <select name="academic_year" id="academic_year"
                style="width: 130px; height: 35px; padding: 5px; border: 1px solid #edeaea; border-radius: 5px;">
                <option>Apply Filter</option>
                <option value="2023-24">2023-24</option>
                <option value="2024-25">2024-25</option>
                <option value="2022-23">2022-23</option>
              </select>
            </div>

          </div>

          <div class="total-class-wise-details" style="margin-left:910px;margin-top:-60px;">


            <div class="first-card"
              style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left:-130px;">
              <h3 style="margin-left:25px;margin-top:10px;">
                <?php

                $dacdyear = "SELECT default_acdyear FROM dhacdyear";
                $dacdyear_run = mysqli_query($con, $dacdyear);
                if (mysqli_num_rows($dacdyear_run)) {
                  while ($rows = mysqli_fetch_assoc($dacdyear_run)) {

                    $default_acdyear = $rows['default_acdyear'];

                    $sqlPaidFees = "SELECT sum(payamt) AS paidFees FROM payment WHERE acdyear = '$default_acdyear'";
                    $resultPaidFees = mysqli_query($con, $sqlPaidFees);
                    if (mysqli_num_rows($resultPaidFees) > 0) {
                      while ($row = mysqli_fetch_assoc($resultPaidFees)) {
                        $paidFees = $row['paidFees'];
                        echo $paidFees;
                      }
                    }

                  }
                }

                ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:25px;margin-top:-20px;">Paid Fees</span>

              </div>
            </div>

            <div class="second-card"
              style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left:27px;">
              <h3 style="margin-left:30px;margin-top:10px;">
                <?php

                $dacdyear_two = "SELECT default_acdyear FROM dhacdyear";
                $dacdyear_run_two = mysqli_query($con, $dacdyear_two);
                if (mysqli_num_rows($dacdyear_run)) {
                  while ($rows_two = mysqli_fetch_assoc($dacdyear_run_two)) {

                    $default_acdyear_two = $rows_two['default_acdyear'];

                    $sqlTotalFees = "SELECT sum(total_fees) AS totalFees FROM acdyear WHERE acdyear = '$default_acdyear_two'";
                    $resultTotalFees = mysqli_query($con, $sqlTotalFees);
                    if (mysqli_num_rows($resultTotalFees) > 0) {
                      while ($row = mysqli_fetch_assoc($resultTotalFees)) {
                        $totalFees = $row['totalFees'];
                        echo $totalFees;
                      }
                    }
                  }
                }
                ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:30px;margin-top:-20px;">Total Fees</span>

              </div>
            </div>

            <div class="third-card"
              style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left: 180px;">
              <h3 style="margin-left:30px;margin-top:10px;">
                <?php
                echo $totalFees - $paidFees;
                ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:25px;margin-top:-20px;">Due Remain</span>

              </div>
            </div>
          </div>

          <div class="student-list-table"
            style="width:930px;margin-left: 290px;background-color: #fff;border-radius: 10px;height: 600px;margin-top: 100px;">
            <div class="table-header">
              <select name="status" id="status"
                style="width:130px;height:35px;margin-left:30px;margin-top:20px;padding: 5px;border-color: #edeaea;border-radius: 5px;">
                <option>Pay Mode Filter</option>
                <option value="All">All</option>
                <option value="Cash">Cash</option>
                <option value="Account">Account</option>
              </select>

              <a href="logout.php">
                <button
                  style="height:30px;width:70px;margin-top:20px;margin-left:10px;background-color:rgb(250, 174, 93);color:#fff;border:none;border-radius: 5px;">Apply</button>
              </a>

              <hr style="margin-top: 15px;color: #ffffff;">
            </div>
            <div class="table" id="student-table" style="margin-left: 30px;;">

              <table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amt</th>
                    <th>Mode</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlFetchStudents = "SELECT * FROM students
                                    JOIN payment ON students.sid = payment.sid
                                    ORDER BY payment.paydate DESC";
                  $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);

                  $no = 0;
                  if (mysqli_num_rows($resultFetchStudents) > 0) {
                    while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {

                      $email = $rows['email'];

                      $status = $rows['status'];
                      $rowClass = '';

                      if ($status == 'Active') {
                        $rowClass = 'active-status';
                      } elseif ($status == 'Pending') {
                        $rowClass = 'pending-status';
                      } elseif ($status == 'Suspended') {
                        $rowClass = 'suspended-status';
                      }

                      ?>
                      <tr>

                        <td>
                          <span style="color:#000;">
                            <?php echo $no + 1; ?>
                          </span>
                        </td>
                        <td>
                          <?php echo $rows['paydate']; ?>
                        </td>

                        <td>
                          <?php echo $rows['payamt']; ?>
                        </td>
                        <td>
                          <?php echo $rows['paymode']; ?>
                        </td>



                        <td>
                          <a href="payment_due.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration: none;color:#000;">
                            <span style="font-size:15px ;">
                              <?php echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?>
                            </span>
                          </a>


                        </td>



                        <td>
                          <a href="payment_due.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration:none;">
                            <i class="fa fa-eye" style="margin-left:15px;"></i>
                          </a>
                          <a href="payment_edit.php?payid=<?php echo $rows['payid']; ?>" style="text-decoration:none;">
                            <i class="fa fa-edit" style="margin-left:15px;"></i>
                          </a>

                        </td>
                      </tr>

                      <?php
                      $no++;
                    }
                  }

                  ?>
                </tbody>
              </table>

            </div>

          </div>

          <div id="paymentModal" class="modal">
            <div class="modal-content">

              <div class="searchable-select-box" style="margin-left:420px;margin-top:-28px;">

                <?php
                // Execute a SQL query to select student names from the database
                $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM students");
                echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                echo "<option>Select Student</option>";
                while ($row = mysqli_fetch_array($direct)) {
                  echo "<option value='" . $row['sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
                }
                echo "</select>";
                ?>
              </div>
            </div>
          </div>
          <script>
            $(document).ready(function () {
              // Initial table load with default academic year
              <?php
              $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
              $year = mysqli_fetch_assoc($year_query);
              $default_acdyear = $year['default_acdyear'];
              ?>
              updateStudentTable("<?php echo $default_acdyear; ?>");
              // updateStudentTable("2023-24");
              // updateStudentTable("2024-25");

              function updateStudentTable(selectedYear) {
                $.ajax({
                  url: "payacdFilter.php",
                  method: "POST",
                  data: { academic_year: selectedYear },
                  success: function (data) {
                    $("#student-table tbody").html(data);
                  },
                  error: function () {
                    $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                  }
                });
              }

              // Handle academic year change
              $("#academic_year").change(function () {
                var selectedYear = $(this).val();
                updateStudentTable(selectedYear);
              });
            });


            <?php
            $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
            $year = mysqli_fetch_assoc($year_query);
            $default_acdyear = $year['default_acdyear'];
            ?>
            updateStudentTable("<?php echo $default_acdyear; ?>");
            // updateStudentTable("2023-24");
            // updateStudentTable("2024-25");

            function updateStudentTable(selectedStatus) {
              $.ajax({
                url: "modeFilter.php",
                method: "POST",
                data: { paymode: selectedStatus },
                success: function (data) {
                  $("#student-table tbody").html(data);
                },
                error: function () {
                  $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                }
              });
            }


            $("#status").change(function () {
              var selectedStatus = $(this).val();
              updateStudentTable(selectedStatus);
            });

          </script>

          <!-- Include jQuery library -->
          <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

          <!-- Include Chosen jQuery plugin -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

          <!-- Include Chosen CSS -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

          <!-- Initialize Chosen on the 'search' select element -->
          <script>
            $('#fetch').chosen();
          </script>

          <script>
            // Get the modal and close button
            var modal = document.getElementById("paymentModal");
            var closeModal = document.getElementById("closeModal");

            // Function to open the modal
            function openModal() {
              modal.style.display = "block";
            }

            // Function to close the modal
            function closeModal() {
              modal.style.display = "none";
            }

            // Event listener to open the modal when the "Add Payment" button is clicked
            document.getElementById("addPaymentButton").addEventListener("click", openModal);

            // Event listener to close the modal when the close button is clicked
            closeModal.addEventListener("click", closeModal);

            // Event listener to close the modal when clicking outside the modal
            window.addEventListener("click", function (event) {
              if (event.target == modal) {
                closeModal();
              }
            });
          </script>


        </body>

        </html>

        <?php
        // row 
        mysqli_free_result($count_run);
      } else {
        echo "Error: " . mysqli_error($con);
      }

      // row 1
      mysqli_free_result($ukg_run);
    } else {
      echo "Error: " . mysqli_error($con);
    }

    // row 2
    mysqli_free_result($lkg_run);
  } else {
    echo "Error: " . mysqli_error($con);
  }

  // row 3
  mysqli_free_result($nur_run);
} else {
  echo "Error: " . mysqli_error($con);
}
?>