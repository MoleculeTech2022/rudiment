<?php
include 'dbcon.php';
include 'sidebar.html';

// Check if 'sid' is set in the URL
if (isset($_GET['sid'])) {
    // Sanitize the input
    $student_id = mysqli_real_escape_string($con, $_GET['sid']);

    // Construct your SQL query
    $query = "SELECT * FROM feesplan
  JOIN students ON students.sid = feesplan.sid
              WHERE students.sid = '$student_id'";



    // Execute the query
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Check if there are any matching records
        if (mysqli_num_rows($query_run) > 0) {
            $student = mysqli_fetch_assoc($query_run);

            $sql = "SELECT SUM(payamt) AS total_amount FROM payment WHERE sid = $student_id ";
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
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Fees Planner - RUDIMENT</title>
                <style>
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

                    table .icon {
                        color: #000;
                    }
                </style>
            </head>

            <body>
                <!-- Begin of Top Navbar -->
                <div class="navbar"
                    style="margin-left:261px;width:80%;height: 70px;position: fixed;background-color: rgb(241, 246, 251);display: flex;">
                    <div class="title" style="margin-top: 22px;margin-left: 30px;">
                        <span>Fees Planner</span>
                    </div>
                    <div class="search-bar"> <!-- Search bar code -->
                        <input type="search" placeholder="Search Anything..."
                            style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:100px;">
                    </div>
                    <!-- icon  -->
                    <!-- <div class="icons" style="margin-left:20px;margin-top:25px;">
      <i class="bx bx-user icon"></i>
    </div> -->

                    <!-- Username Button  -->
                    <div class="" style="margin-left: 10px; margin-top: 20px;">
                        <a href="userprofile.php" style="text-decoration: none; display: flex; align-items: center;">
                            <button
                                style="width: 150px; height: 30px; background-color: #47cbec; border-width: 1px; border-radius: 20px; color: #a70909; display: flex; align-items: center; padding: 0; margin: 0;">
                                <i class="bx bx-user icon" style="margin-left: 10px;"></i>
                                <span style="margin-left: 5px;">
                                    <?php echo $_SESSION['username'] ?>
                                </span>
                            </button>
                        </a>
                    </div>

                    <!-- Logout Button  -->
                    <div class="log-out-btn" style="margin-left: 10px; margin-top: 20px;">

                        <a href="../adminh/index.php" style="text-decoration:none;">
                            <button
                                style="width: 30px; height: 30px; background-color: aliceblue; border-width: 1px; border-radius: 20px; color: #000000;">H</button>
                        </a>

                        <a href="logout.php">
                            <button
                                style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
                        </a>

                    </div>
                </div>
                <!-- End of Top Navbar -->
                <div class="dashboard-contents"
                    style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">


                    <!-- Select student to make payment  -->
                    <div class="select-student-form">
                        <form action="code.php" method="POST" style="margin-top:0px;">

                            <div class="searchable-select-box" style="margin-left:30px;">

                                <?php
                                // Execute a SQL query to select student names from the database
                                $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM students");

                                // Create a dropdown select element
                                echo "<select disabled  id='fetch' name='sid' style='height:30px;margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;background-color:#fff;'>";
                                echo "<option value=''>" . $student['fname'] . " " . $student['mname'] . " " . $student['lname'] . "</option>";

                                // Loop through the results and populate the select options with student names
                                while ($row = mysqli_fetch_array($direct)) {
                                    echo "<option value='" . $row[' sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " .
                                        $row['mname'] . " " . $row['lname'] . "</option>";
                                } ?>
                            </div>

                            <input type="number" value="<?php echo $student['planamt']; ?>" required name="planamt"
                                placeholder="Your Amount"
                                style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <br>


                            <textarea name="remarks" placeholder="Remarks"
                                style="margin-left:0px;margin-top:20px;padding:5px;width: 450px;border-radius:5px;border-width:1px;height:50px; color: #555; font-style: italic;">
                                                                                                                                            <?php echo $student['remarks']; ?></textarea><br>

                            <input type="date" required name="plandate" value="<?php echo $student['plandate']; ?>" id="paydate"
                                placeholder="Your Amount Date"
                                style="margin-left:0px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;"><br>



                            <div class="payment-update-btn"
                                style="margin-left:0px;margin-top:-33px;margin-bottom:20px;height:300px;margin-left:230px;">

                                <button class="payment-update-btn" id="refreshButton" value="submit" name="update_feesplan"
                                    style="width:220px;height:35px;border-radius:5px;background-color:#00eaff;border-width:1px;"
                                    id="refreshButton">Update Plan</button>


                            </div>
                        </form>



                    </div>

                </div>

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

            </body>

            </html>
            <?php
        }
    }

}
?>