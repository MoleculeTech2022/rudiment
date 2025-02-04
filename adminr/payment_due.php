<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Timeline - RUDIMENT</title>
    <!-- jquery file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Ajax CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .payment_details_card {
            width: 950px;
            height: 280px;
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #000;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
            margin-left: 280px;
            margin-top: 20px;
            overflow-y: auto;
            position: relative;
        }

        .student-details-card {
            width: 950px;
            height: 180px;
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #000;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.25);
            margin-left: 280px;
            margin-top: -10px;
            overflow-y: auto;
            position: relative;
        }

        .payment-timeline-card {
            width: 700px;
            height: 40px;
            border-radius: 2px;
            background-color: #fff9e5;
            margin-top: 10px;
            position: relative;
        }
    </style>
</head>

<body>

    <?php
    // Include database connection
    include "dbcon.php";
    // Include sidebar which has check login feature
    include "sidebar.html";

    // Check if the user is not logged in, then redirect to the login page
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['sid'])) {
        // Student ID received here
        $student_id = mysqli_real_escape_string($con, $_GET['sid']);
    ?>

        <div class="student-details-card">
            <?php
            $student_details = "SELECT * FROM students
                                JOIN parents ON parents.sid = students.sid
                                WHERE students.sid = '$student_id'";
            $student_details_run = mysqli_query($con, $student_details);

            if (mysqli_num_rows($student_details_run) > 0) {
                while ($rows = mysqli_fetch_assoc($student_details_run)) {
            ?>

                    <div class="back-btn" style="margin-top:20px;">
                        <a href="student-view.php?sid=<?= $student_id; ?>" style="text-decoration:none;">
                            <button style="height:40px;width:100px;margin-top:0px;margin-left:830px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Back</button>
                        </a>
                    </div>
                    <div class="student_details" style="margin-top: -50px;">
                        <div class="student_name" style="margin-top: 10px;margin-left:10px;position:absolute;width:950px;">
                            <h4>Student Name : <?= $rows['fname'] . " " . $rows['mname'] . " " . $rows['lname']; ?></h4>
                        </div>
                        <div class="student_current_class" style="margin-top: 40px;margin-left:10px;position:absolute;width:950px;">
                            <h4>Class : <?= $rows['current_class']; ?></h4>
                        </div>
                        <div class="mother_contact" style="margin-top: 70px;margin-left:10px;position:absolute;width:950px;">
                            <h4>Mob : <?= $rows['mcontact']; ?></h4>
                        </div>
                        <div class="academic_year_search">
                            <select name="acdyearFilter" title="Academic Year" id="acdyearFilter" style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:10px;margin-top:110px;">
                                <option value="all">Select Academic Year</option>
                                <option value="2024-25">2024-25</option>
                                <option value="2023-24">2023-24</option>
                                <option value="2022-23">2022-23</option>
                                <option value="2025-26">2025-26</option>
                            </select>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <?php
        // Select student query
        $query = "SELECT acdyear FROM acdyear WHERE sid = '$student_id' ORDER BY aid DESC";
        // Query running
        $query_run = mysqli_query($con, $query);

        if (mysqli_num_rows($query_run) > 0) {
            while ($rows = mysqli_fetch_assoc($query_run)) {
                // Select student query
                $acdyear = $rows['acdyear'];
        ?>

                <div class="payment_details_card">
                    <div class="academic_year_span" style="margin-top: 10px;margin-left:10px;position:absolute;width:950px;">
                        <h4>Academic Year : <?php echo $acdyear; ?></h4>
                    </div>

                    <!-- Payment Details Button -->
                    <div class="buttons-container" style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 10px; margin-left: 220px;">
                        <form action="bill.php" method="get" style="margin: 0;">
                            <input type="hidden" name="sid" value="<?= $student_id; ?>">
                            <input type="hidden" name="acdyear" value="<?= $acdyear; ?>">
                            <button type="submit" style="width: 170px; height: 35px; background-color: rgb(225, 225, 249); border-radius: 10px; border: none; cursor: pointer; position: relative;">
                                <span style="display: inline-block; width: 100%; height: 100%; text-align: center; line-height: 35px;">
                                    Print Receipt
                                    <img src="./images/overview.png" style="width: 20px; height: 20px; margin-left: 10px; vertical-align: middle;">
                                </span>
                            </button>
                        </form>

                        <form action="make_payment.php" method="get" style="margin: 0;">
                            <input type="hidden" name="sid" value="<?= $student_id; ?>">
                            <input type="hidden" name="acdyear" value="<?= $acdyear; ?>">
                            <button type="submit" style="width: 170px; height: 35px; background-color: rgb(225, 225, 249); border-radius: 10px; border: none; cursor: pointer; position: relative;">
                                <span style="display: inline-block; width: 100%; height: 100%; text-align: center; line-height: 35px;">
                                    Make Payment
                                    <i class="bx bx-credit-card-alt" style="margin-left: 3px; vertical-align: middle;"></i>
                                </span>
                            </button>
                        </form>

                        <form action="paytimeline.php" method="get" style="margin: 0;">
                            <input type="hidden" name="sid" value="<?= $student_id; ?>">
                            <input type="hidden" name="acdyear" value="<?= $acdyear; ?>">
                            <button type="submit" style="width: 173px; height: 35px; background-color: rgb(225, 225, 249); border-radius: 10px; border: none; cursor: pointer; position: relative;">
                                <span style="display: inline-block; width: 100%; height: 100%; text-align: center; line-height: 35px;">
                                    Payment Details
                                    <i class="bx bx-credit-card-alt" style="margin-left: 3px; vertical-align: middle;"></i>
                                </span>
                            </button>
                        </form>
                    </div>




                    <!-- Start of - FEES & DUE AMOUNT DISPLAY  -->
                    <div class="payment-details" style="position:absolute; margin-left:10px; margin-top:3px;">
                        <!-- new div added by vinit  -->
                        <div>
                            <?php
                            $query_fees = "SELECT total_fees FROM acdyear WHERE sid = '$student_id' AND acdyear = '$acdyear'";
                            $query_run_fees = mysqli_query($con, $query_fees);
                            if (mysqli_num_rows($query_run_fees) > 0) {
                                while ($rows_fees = mysqli_fetch_assoc($query_run_fees)) {
                            ?>
                                    <div class="total_fees">
                                        <h2><?= $rows_fees['total_fees']; ?></h2>
                                        <span>Total Fees</span>
                                    </div>
                                    <div class="paid_fees" style="margin-top:-60px; margin-left:200px;">
                                        <?php
                                        $paid_fees = "SELECT SUM(payamt) AS total_paid_fees FROM payment WHERE sid = '$student_id' AND acdyear = '$acdyear'";
                                        $paid_fees_run = mysqli_query($con, $paid_fees);
                                        if (mysqli_num_rows($paid_fees_run) > 0) {
                                            while ($paid = mysqli_fetch_assoc($paid_fees_run)) {
                                        ?>
                                                <h2><?= $paid['total_paid_fees']; ?></h2>
                                                <span>Paid Fees</span>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="due_amount" style="margin-top:-60px; margin-left:400px;">
                                        <?php
                                        $paid_fees = "SELECT SUM(payamt) AS total_paid_fees FROM payment WHERE sid = '$student_id' AND acdyear = '$acdyear'";
                                        $paid_fees_run = mysqli_query($con, $paid_fees);
                                        if (mysqli_num_rows($paid_fees_run) > 0) {
                                            while ($paid = mysqli_fetch_assoc($paid_fees_run)) {
                                                $due_amount = $rows_fees['total_fees'] - $paid['total_paid_fees'];
                                        ?>
                                                <h2>
                                                    <?php
                                                    if ($due_amount != 0) {
                                                        echo $due_amount;
                                                    ?>
                                                </h2>
                                                <span>Due Amount</span>
                                            <?php
                                                    } else {
                                            ?>
                                                <h2>0</h2>
                                                <span style="color: green;">No Due Amount</span>
                                            <?php
                                                    }
                                            ?>
                                            </h2>
                                    <?php
                                            }
                                        }
                                    ?>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <!-- new div added by vinit  -->
                    </div>

                    <!-- End of - FEES & DUE AMOUNT DISPLAY  -->

                    <div class="payment-timeline-div" style="margin-top:70px; margin-left:20px;">
                        <hr>
                        <h4 style="margin-left:0px;">Payment Timeline</h4>
                        <?php
                        // Fetching payment timeline by academic year
                        $payment_timeline = "SELECT * FROM payment WHERE sid = '$student_id' AND payment.acdyear = '$acdyear'";
                        $payment_timeline_run = mysqli_query($con, $payment_timeline);
                        if (mysqli_num_rows($payment_timeline_run) > 0) {
                            while ($rows_timeline = mysqli_fetch_assoc($payment_timeline_run)) {
                                // Taking payid in variable
                                $payid = $rows_timeline['payid'];
                        ?>
                                <div class="payment-timeline-card">
                                    <div class="span-div_one" style="position:absolute;margin-top:7px;">
                                        <span style="margin-left: 10px;">Amount : <?= $rows_timeline['payamt']; ?></span>
                                    </div>
                                    <div class="span-div_two" style="position:absolute;margin-top:7px;">
                                        <span style="margin-left: 200px;">Mode : <?= $rows_timeline['paymode']; ?></span>
                                    </div>
                                    <div class="span-div_three" style="position:absolute;margin-top:7px;">
                                        <span style="margin-left: 400px;">Date : <?= $rows_timeline['paydate']; ?></span>
                                    </div>
                                    <div class="icons" style="position:absolute;margin-top:7px;">
                                        <a href="payment_edit.php?payid=<?= $payid; ?>">
                                            <img src="./images/edit_icon_square.png" style="width:20px;height:20px;margin-left:620px;">
                                        </a>
                                    </div>
                                </div>
                        <?php
                            } // End of payment timeline while loop
                        } // End of payment timeline if statement
                        ?>
                    </div>
                </div>
        <?php
            } // End of $query_run while loop
        } // End of $query_run if statement
        ?>

    <?php
    } else {
    ?>
        <script>
            alert("Student ID not received.");
            window.location.href = "students.php";
        </script>
    <?php
    }
    ?>

    <!-- Search academic year filter -->
    <script>
        $(document).ready(function() {
            // Handle academic year change
            $("#acdyearFilter").change(function() {
                var selectedYear = $(this).val();
                var sid = <?php echo $student_id; ?>;
                updateStudentTable(selectedYear, sid);
            });

            function updateStudentTable(selectedYear, sid) {
                $.ajax({
                    url: "payment_due_acd_filter.php",
                    method: "POST",
                    data: {
                        academic_year: selectedYear,
                        sid: sid
                    },
                    success: function(data) {
                        $(".payment_details_card").empty().html(data);
                    },
                    error: function() {
                        $(".payment_details_card").html('<h1>Error loading data.</h1>');
                    }
                });
            }
        });
    </script>
</body>

</html>