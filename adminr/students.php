<?php
include "dbcon.php";
include "sidebar.html";


$dacdyear = "SELECT default_acdyear FROM dacdyear";
$run_dacdyear = mysqli_query($con, $dacdyear);
if (mysqli_num_rows($run_dacdyear) > 0) {
  while ($rows = mysqli_fetch_assoc($run_dacdyear)) {
    $default_acdyear = $rows['default_acdyear'];


// SQL query to count students
    $count = "SELECT COUNT(*) AS student_count FROM students";
    $ukg = "SELECT COUNT(*) AS ukg_count FROM students 
JOIN acdyear ON students.sid = acdyear.sid
WHERE current_class = 'UKG' AND acdyear.acdyear = '$default_acdyear'";
    $lkg = "SELECT COUNT(*) AS lkg_count FROM students 
JOIN acdyear ON students.sid = acdyear.sid
WHERE current_class = 'LKG' AND acdyear.acdyear = '$default_acdyear'";
    $nur = "SELECT COUNT(*) AS nur_count FROM students 
JOIN acdyear ON students.sid = acdyear.sid
WHERE current_class = 'NUR' AND acdyear.acdyear = '$default_acdyear'";


  }
}

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
          <title>RUDIMENT - Students</title>

          <!-- // boxicons icon link cdn -->
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/boxicons.min.css">


          <!-- // fontawesome css link -->
          <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
          <!-- jquery file -->
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <!-- // student search script -->
          <script>
            $(document).ready(function () {
              $("#search").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                  url: "studentFilter.php",
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
              <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Students</span><br>
              <span style="font-size:35px;margin-left:290px;margin-top:20px;">Students List</span><br>
              <span style="margin-left:290px;margin-top:20px;font-size: 12px;">All Rudiment students manage here.</span>

            </div>
            <div class="buttons" style="margin-left:990px;margin-top:-90px;">
              <a href="admission.php" style="text-decoration:none;">
                <button
                  style="height:40px;width:100px;margin-top:20px;margin-left:-10px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                  Student</button>
              </a>
              <a href="payments.php">
                <button
                  style="height:40px;width:130px;margin-top:20px;margin-left:10px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">Payments
                  History</button>
              </a>
            </div>

            <div class="search" style="margin-top: 53px;margin-left:290px;">
              <input type="text" placeholder="search..." name="search" id="search"
                style="width: 250px; height: 35px; padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
            </div>

            <div class="filter-select-box" style="margin-top: -36px; margin-left: 560px;">
              <select name="academic_year" id="academic_year"
                style="width: 185px; height: 35px; padding: 5px; border: 1px solid #edeaea; border-radius: 5px;">
                <option>Select Academic Year</option>
                <option value="all">All</option>
                <option value="2024-25">2024-25</option>
                <option value="2023-24">2023-24</option>
                <option value="2022-23">2022-23</option>
                <option value="2025-26">2025-26</option>
              </select>
            </div>

          </div>

          <div class="total-class-wise-details" style="margin-left:910px;margin-top:-60px;">

            <div class="first-card"
              style="position:absolute;width:90px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;">
              <h3 style="margin-left:30px;margin-top:10px;">
                <?php echo $nurCount; ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:25px;margin-top:-20px;">NUR</span>

              </div>
            </div>

            <div class="second-card"
              style="position:absolute; width:90px; height:80px; background-color: #fff; box-shadow:1px 1px 1px 1px #edeaea; border-radius: 5px; margin-left:110px; margin-top: 0px;">
              <h3 style="margin-left:30px;margin-top:10px;">
                <?php echo $lkgCount; ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:25px;margin-top:-20px;">LKG</span>

              </div>
            </div>

            <div class="third-card"
              style="position:absolute;width:90px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left: 220px;">
              <h3 style="margin-left:30px;margin-top:10px;">
                <?php echo $ukgCount; ?>
              </h3><br>
              <div class="titile" style="margin-top:-20px;">
                <span style="margin-left:25px;margin-top:-20px;">UKG</span>

              </div>

            </div>
          </div>
          </div>
          </div>

          <div class="student-list-table"
            style="width:930px;margin-left: 290px;background-color: #fff;border-radius: 10px;height: 600px;margin-top: 100px;">
            <div class="table-header">
              <select name="status" id="status"
                style="width:130px;height:35px;margin-left:30px;margin-top:20px;padding: 5px;border-color: #edeaea;border-radius: 5px;">
                <option>Status Filter</option>
                <option value="Active">Active</option>
                <option value="Pending">Pending</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Suspended">Suspended</option>
              </select>

              <button
                style="height:30px;width:70px;margin-top:20px;margin-left:10px;background-color:rgb(250, 174, 93);color:#fff;border:none;border-radius: 5px;">Apply</button>

              <a href="complaint.php" style="text-decoration:none;">
                <button
                  style="height:30px;width:150px;margin-top:20px;margin-left:490px;background-color:rgb(250, 93, 93);color:#fff;border:none;border-radius: 3px;">Check
                  Complaints</button>
              </a>


              <hr style="margin-top: 15px;color: #ffffff;">
            </div>
            <div class="table" id="student-table" style="margin-left: 30px;;">

              <table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Current Class</th>
                    <th>DOA</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  // Please also change in acdFilter
                  
                  // student fetching query
                  $sqlFetchStudents = "SELECT * FROM students
                        JOIN parents ON students.sid = parents.sid
                        JOIN acdyear ON students.sid = acdyear.sid
                        ORDER BY students.doa DESC";

                  // student fetching query
                  $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);
                  $count = 0;

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

                        <td style="color:#000;">
                          <?php
                          echo $count + 1;
                          ?>
                        </td>
                        <td>
                          <a href="student-view.php?sid=<?php echo $rows['sid']; ?>" style="text-decoration: none;color:#000;">
                            <span style="font-size:15px ;">
                              <?php echo $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?>
                            </span>
                          </a>
                          <br>
                          <span style="font-size:10px;">
                            <?php
                            if ($email == '') {
                              echo $rows['fname'] . "@gmail.com";
                            } else {
                              echo $email;
                            } ?>
                          </span>

                        </td>
                        <td>
                          <?php echo $rows['current_class']; ?>
                        </td>
                        <td>
                          <?php echo $rows['doa']; ?>
                        </td>
                        <td>
                          <?php echo $rows['mcontact']; ?>
                        </td>

                        <td class="<?php echo $rowClass; ?>">
                          <?php echo $status; ?>
                        </td>

                        <td>
                          <a href="student-view.php?sid=<?php echo $rows['sid']; ?>">
                            <i class="bx bx-id-card" style="margin-left:15px;"></i>
                          </a>
                          <a href="student-edit.php?sid=<?php echo $rows['sid']; ?>">
                            <i class="fa fa-edit" style="margin-left:15px;"></i>
                          </a>
                        </td>
                      </tr>

                      <?php
                      $count++;
                    }
                  }

                  ?>
                </tbody>
              </table>

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
                  url: "acdFilter.php",
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

          </script>

          <script>

            function updateStudentTable(selectedStatus) {
              $.ajax({
                url: "statusFilter.php",
                method: "POST",
                data: { status: selectedStatus },
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


            function openMenu(dot) {
              // Get the menu element associated with the clicked three dots
              var menu = dot.nextElementSibling;

              // Toggle the menu's visibility
              if (menu.style.display === "block") {
                menu.style.display = "none";
              } else {
                menu.style.display = "block";
              }

              // Close any other open menus
              var allMenus = document.querySelectorAll(".menu");
              for (var i = 0; i < allMenus.length; i++) {
                if (allMenus[i] !== menu) {
                  allMenus[i].style.display = "none";
                }
              }
            }



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