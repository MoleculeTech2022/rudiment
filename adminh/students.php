<?php
require 'dbcon.php';
include "sidebar.html";

// SQL query to count students
$count = "SELECT COUNT(*) AS student_count FROM hstudents";
$ukg = "SELECT COUNT(*) AS ukg_count FROM hstudents WHERE classAdmitted = '1st'";
$lkg = "SELECT COUNT(*) AS lkg_count FROM hstudents WHERE classAdmitted = '2nd'";
$nur = "SELECT COUNT(*) AS nur_count FROM hstudents WHERE classAdmitted = '3rd'";
$male = "SELECT COUNT(gender) AS male_count FROM hstudents WHERE gender = 'male'";
$female = "SELECT COUNT(*) AS female_count FROM hstudents WHERE gender = 'female'";


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

        if ($male_run) {
          // Fetch the ukg count
          $row4 = mysqli_fetch_assoc($male_run);
          $maleCount = $row4['male_count'];

          if ($female_run) {
            // Fetch the ukg count
            $row5 = mysqli_fetch_assoc($female_run);
            $femaleCount = $row5['female_count'];


            // fetch default acdyear query
            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>HABITUDE - Students</title>

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
                      url: "filter.php", // Create a PHP script for filtering
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

                /* // table ke row ke andar ke icon ko black kiya hai */
                table .icon {
                  color: #000;
                }
              </style>
            </head>

            <body>
              <div class="container">

                <!-- Top Navbar  -->
                <div class="navbar"
                  style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
                  <div class="title" style="margin-top: 22px;margin-left: 30px;">
                    <span>Students</span>
                    <div class="academic-year-filter" style="margin-top:-17px;margin-left:10px;">
                      <select name="academic_year" id="academic_year"
                        style="width:90px;height:30px;padding:5px;border:none;border-radius:20px;margin-left:70px;margin-top:-30px;">
                        <?php
                        $default_acdyear = "SELECT default_acdyear FROM dhacdyear";
                        $acdyearResult = mysqli_query($con, $default_acdyear);
                        if (mysqli_num_rows($acdyearResult) > 0) {
                          while ($acdyear = mysqli_fetch_assoc($acdyearResult)) {


                            echo '<option value="' . $acdyear['default_acdyear'] . '">' . $acdyear['default_acdyear'] . '</option>';

                          }
                        }
                        ?>
                        <option value="2024-25">2024-25</option>
                        <option value="2022-23">2022-23</option>
                      </select>

                    </div>

                  </div>
                  <div class="search-bar">
                    <input type="search" placeholder="Search Your Student..." id="search" name="search"
                      style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:260px;">
                  </div>
                  <div class="icons" style="margin-left:25px;margin-top:25px;">

                    <a href="admission.php"><i class='bx bx-message-square-add icon'></i></a>
                  </div>
                  <div class="log-out-btn" style="margin-left:10px;margin-top:20px;">
                    <button
                      style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
                  </div>
                </div>
                <!-- Top Navbar  -->

                <div class="dashboard-contents"
                  style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

                  <!-- // students details counts card -->
                  <div class="total-numbers"
                    style="position:absolute;width:890px;margin-top:10px;height:90px;background-color:rgb(246, 250, 253);box-shadow: 1px 1px 1px 1px #edeaea;margin-left:30px;border-radius:10px;">
                    <div class="title" style="margin-top:10px;">
                      <h4 style="margin-left:10px;margin-top:7px;">Students Details</h4><br>
                      <div class="total-students" style="margin-top:-17px;">
                        <span style="margin-left:10px;">Total Students :
                          <?php echo $studentCount; ?>
                        </span>
                      </div>
                      <!-- class wise students count -->
                      <div class="class-wise-students-count" style="margin-top:-48px;">
                        <span style="margin-left:260px;" onclick="ukg()">Class 1 :
                          <?php echo $ukgCount; ?>
                        </span>
                        <span style="margin-left:50px;">Class 2 :
                          <?php echo $lkgCount; ?>
                        </span>
                      </div>
                      <!-- // nursery students count -->
                      <div class="male-students-count" style="margin-top:10px; ">
                        <span style="margin-left:260px;">Male :
                          <?php echo $maleCount; ?>
                        </span>
                      </div>

                      <!-- // nursery students count -->
                      <div class="gender-students-count" style="margin-top:-58px;margin-left:230px;">
                        <span style="margin-left:270px;">Class 3 :
                          <?php echo $nurCount; ?>
                        </span>
                      </div>

                      <div class="female-students-count" style="margin-top:10px; ">
                        <span style="margin-left:386px;">Female :
                          <?php echo $femaleCount; ?>
                        </span>
                      </div>

                    </div>
                  </div>

                  <table class="content-table" id="student-table" style="margin-left :30px;margin-top:130px;">
                    <thead>
                      <tr>
                        <th style="color: #000000;">#</th>
                        <th style="color: #000000;">Name</th>
                        <th style="color: #000000;">Class</th>
                        <th style="color: #000000;">DOB</th>
                        <th style="color: #000000;">Phone</th>
                        <th style="color: #000000;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sqlFetchStudent = "SELECT * FROM hstudents JOIN hparents ON hstudents.sid = hparents.sid";
                      $resultFetchStudent = mysqli_query($con, $sqlFetchStudent);
                      if (mysqli_num_rows($resultFetchStudent) > 0) {
                        while ($student = mysqli_fetch_assoc($resultFetchStudent)) {
                          ?>
                          <tr>
                            <td>
                              <?= $student['sid']; ?>
                            </td>
                            <td>
                              <?= $student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname']; ?>
                            </td>
                            <td>
                              <?= $student['classAdmitted']; ?>
                            </td>
                            <td>
                              <?= $student['dob']; ?>
                            </td>
                            <td>
                              <?= $student['fcontact']; ?>
                            </td>
                            <td>
                              <a href="student-view.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                                <i class="bx bx-show icon" style="color:#000;"></i>
                              </a>
                              <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                                <i class="bx bx-edit icon" style="color:#000;"></i>
                              </a>
                              <a href="student-edit.php?sid=<?= $student['sid']; ?>" style="text-decoration:none;">
                                <i class="bx bx-heart icon" style="color:#000;"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                        }
                      } else {
                        echo "<h5> No Record Found </h5>";
                      }
                      ?>

                    </tbody>
                  </table>

                </div>
              </div>

              <script>

                $(document).ready(function () {
                  // Initial table load with default academic year
                  <?php
                  $year_query = mysqli_query($con, "SELECT default_acdyear FROM dhacdyear");
                  $year = mysqli_fetch_assoc($year_query);
                  $default_acdyear = $year['default_acdyear'];
                  ?>
                  updateStudentTable("<?php echo $default_acdyear; ?>");
                  // updateStudentTable("2023-24");
                  // updateStudentTable("2024-25");

                  function updateStudentTable(selectedYear) {
                    $.ajax({
                      url: "ayear.php",
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

                  function ukg() {
                    var searchInput = document.getElementById('search');

                    // Set the value of the input field
                    searchInput.value = "ukg";
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

    // row 4
    mysqli_free_result($male_run);
  } else {
    echo "Error: " . mysqli_error($con);
  }

  // row 5
  mysqli_free_result($female_run);
} else {
  echo "Error: " . mysqli_error($con);
}

?>