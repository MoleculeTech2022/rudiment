<?php
// include "checklogin.php";
include "sidebar.html";
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

    $query = "SELECT * FROM students
            JOIN payment ON students.sid = payment.sid
            JOIN parents ON students.sid = parents.sid
            JOIN acdyear ON students.sid = acdyear.sid
            WHERE students.sid = '$student_id'";

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
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>RUDIMENT - ReAdmission View</title>
                <!-- CSS -->
                <link rel="stylesheet" href="css/style.css">
                <!-- Boxicons CSS -->
                <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
                <style>
                    /* Google Fonts - Poppins */
                    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

                    /* Custom styles for the Chosen select box container */
                    .chosen-container {
                        border: 2px solid #ffffff;
                        background-color: #f5f5f5;
                        color: #000000;
                        border-radius: 5px;
                        box-shadow: 1px 1px 1px 1px #edeaea;
                    }

                    /* Custom styles for the Chosen dropdown list */
                    .chosen-drop {
                        background-color: #fff;
                        border: 1px solid #ccc;
                    }

                    /* Custom styles for the Chosen selected options */
                    .chosen-choices {
                        border: 1px solid #ccc;
                        background-color: #f5f5f5;
                    }
                </style>
            </head>

            <body>

                <div class="second-navigation"
                    style="width:100%;height:40px;background-color:#ffff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:-18px;margin-left:0px;">

                    <div class="secondNavContents" style="margin-left:280px;">
                        <span>To search another student search student here.</span>

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
                        <div class="btns" style="margin-top:-33px;margin-left:720px;">

                            <a href="payments.php" style="text-decoration:none;">
                                <button
                                    style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(49, 217, 255);color:#fff;border:none;border-radius: 5px;">Payments</button>
                            </a>
                            <a href="readmission.php" style="text-decoration:none;">
                                <button
                                    style="height:40px;width:100px;margin-top:0px;margin-left:20px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Back</button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dashboard-contents"
                    style="margin-left:261px;width:500px;height:300px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

                    <div class="student-card"
                        style="position:absolute;width:900px;height:150px;background-color:#fff;box-shadow:1px 1px 1px 1px #edeaea;margin-top:-50px;margin-left:20px;border-radius:5px; ">
                        <a href="student-view.php?sid=<?php echo $student_id ?>" style="text-decoration:none;">
                            <h4 style="display: block; margin-top: 20px;margin-left:20px;">Student Name :
                                <?php echo $student['fname']; ?>
                                <?php echo $student['mname']; ?>
                                <?php echo $student['lname']; ?>
                            </h4>
                        </a>
                        <span style="display: block; margin-top: 5px;margin-left:20px;">Class :
                            <!-- this class is from acdyear table -->
                            <?php echo $student['current_class']; ?>
                        </span>
                        <span style="display: block; margin-top: 5px;margin-left:20px;">Academic Year :
                            <?php echo $student['acdyear']; ?>
                        </span>

                        <!-- <a href="payments.php">
            <button style="margin-left:20px;margin-top:10px;width:110px;background-color: #06de2e;border: none;border-radius: 3px;color:#fff;">Make Payment</button>
            </a> -->

                        <?php

                        $due = $student['total_fees'] - $totalAmount;

                        ?>
                        <div class="fees-details" style="margin-top:20px;">
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
                    </div>

                    <div class="readmission-form" style="margin-top:120px;margin-left:0px;">

                        <div class="readmission-form-header" style="margin-left:18px;">
                            <h2>Re-Admission Form</h2>
                        </div>

                        <form action="readmission_db_code.php" method="POST">

                            <input type="hidden" name="sid" value="<?= $student_id; ?>">

                            <select name="acdyear"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">
                                <option value="2024-25">2024-25</option>
                                <option value="2025-26">2025-26</option>
                                <option value="2023-24">2023-24</option>
                            </select>

                            <select name="student_class"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">
                                <option value="Select Class">Select Class</option>
                                <option value="Play Group">Play Group</option>
                                <option value="NUR">NUR</option>
                                <option value="LKG">LKG</option>
                                <option value="UKG">UKG</option>
                                <option value="Other">Other</option>
                            </select>

                            <input type="number" name="total_fees" placeholder="Total Fees"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                            <input type="number" name="payamt" placeholder="Payment Amount"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                            <input type="date" name="paydate" placeholder="Payment Date" title="Date Of Payment / Re-Admission"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                            <select name="paymode"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">
                                <option value="Select Payment Mode">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="Account">Account</option>
                            </select>

                            <input type="text" name="feesplan" placeholder="Fess Plan"
                                style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                            <button name="readmission_btn"
                                style="height:40px;width:130px;margin-top:0px;margin-left:10px;background-color:rgb(100, 193, 255);color:#fff;border:none;border-radius: 5px;">ReAdmission</button>

                        </form>
                    </div>
                    <?php

        }
    } else {
        echo "No payments found.";
    }
    ?>
        </div>


        <script>
            // Function to redirect to student-view.php with the selected student ID
            function redirectToStudentView(studentID) {
                if (studentID) {
                    window.location.href = 'readmission_view.php?sid=' + studentID;
                }
            }
        </script>

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
} else {
    echo "<h4>No Such ID Found</h4>";
}

?>