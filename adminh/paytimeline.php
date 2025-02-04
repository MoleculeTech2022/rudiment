<?php
include "dbcon.php";
include "sidebar.html";

// Get hhpayment id from hhpayments page
if (isset($_GET['payid'])) {

    // Sanitize the input
    $payid = mysqli_real_escape_string($con, $_GET['payid']);
    // Construct your SQL query
    $query = "SELECT * FROM hpayment JOIN hstudents ON hstudents.sid = hpayment.sid
                  WHERE payid = '$payid'";

    // Execute the query
    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if there are any matching records
        if (mysqli_num_rows($result) > 0) {
            $timeline = mysqli_fetch_assoc($result);
            $sid = $timeline["sid"];

            $sqlSumPaidFees = "SELECT sum(payamt) AS paid_fees FROM hpayment WHERE sid = $sid";
            $resultSumPaidFees = mysqli_query($con, $sqlSumPaidFees);
            if (mysqli_num_rows($resultSumPaidFees) > 0) {
                while ($rows = mysqli_fetch_assoc($resultSumPaidFees)) {

                    $paidfees = $rows['paid_fees'];


                    $sqlSumTotalFees = "SELECT sum(total_fees) AS total_fees FROM hacdyear WHERE sid = $sid";
                    $resultSumTotalFees = mysqli_query($con, $sqlSumTotalFees);
                    if (mysqli_num_rows($resultSumTotalFees) > 0) {
                        while ($rows = mysqli_fetch_assoc($resultSumTotalFees)) {

                            $totalfees = $rows['total_fees'];


                            ?>

                            <!DOCTYPE html>
                            <html lang="en">

                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>HABITUDE - Receipt</title>
                            </head>

                            <body>
                                <div class="container" style="margin-left:320px;">

                                    *FEES UPDATE*
                                    <br>
                                    _Academic Year 2023-24_
                                    <br>
                                    <br>
                                    *STUDENT DETAILS*
                                    <br>
                                    <span>Name :
                                        <?php echo $timeline['fname']; ?>
                                        <?php echo $timeline['mname']; ?>
                                        <?php echo $timeline['lname']; ?>
                                    </span>
                                    <div class="classAdmitted" style="margin-top:0px;">
                                        <span>Class :
                                            <?php echo $timeline['classAdmitted']; ?>
                                        </span>
                                    </div>
                                    <br>
                                    *FEES STATUS*
                                    <div class="paid_fees" style="margin-top:10px;">
                                        <span>Paid Fees :
                                            <?php echo $paidfees; ?>
                                        </span>
                                    </div>
                                    <div class="total_fees" style="margin-top:0px;">
                                        <span>Total Fees :
                                            <?php echo $totalfees; ?>

                                        </span>
                                    </div>
                                    <div class="due_fees" style="margin-top:0px;">
                                        <span>Pending Fees :
                                            <?php echo $totalfees - $paidfees; ?>

                                        </span>
                                    </div>
                                    <br>
                                    *Payment Timeline*
                                    <br>

                                    <?php

                                    $sqlTimeline = "SELECT * FROM hpayment WHERE sid = $sid ORDER BY paydate DESC";
                                    $resultTimeline = mysqli_query($con, $sqlTimeline);
                                    if (mysqli_num_rows($resultTimeline) > 0) {
                                        while ($rows = mysqli_fetch_assoc($resultTimeline)) {
                                            ?>
                                            <span>
                                                <?php echo $rows['payamt']; ?> --
                                                <?php echo $rows['paymode']; ?> --
                                                <?php echo $paydate = date('d', strtotime($rows['paydate'])); ?>-
                                                <?php echo $monthName = date('F', strtotime($rows['paydate'])); ?>-
                                                <?php echo "20" . $paydate = date('y', strtotime($rows['paydate'])); ?>

                                            </span>
                                            <br>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <br>
                                    Management
                                    <br>
                                    *HABITUDE*
                                    <br>
                                    <br>
                                    <hr>

                                </div>
                            </body>

                            </html>
                            <?php

                        }
                    }

                }
            }
        }
    }
}
?>