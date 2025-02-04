<?php
include "dbcon.php";
include "sidebar.html";

// Get payment id from payments page
if (isset($_GET['sid']) && isset($_GET['acdyear'])) {
    // Sanitize the input
    $student_id = mysqli_real_escape_string($con, $_GET['sid']);
    $acdyear = mysqli_real_escape_string($con, $_GET['acdyear']);

    // Sanitize the input
    // $payid = mysqli_real_escape_string($con, $_GET['payid']);
    // Construct your SQL query
    $query = "SELECT * FROM payment JOIN students ON students.sid = payment.sid
                  WHERE payment.sid = '$student_id' AND payment.acdyear = '$acdyear'";

    // Execute the query
    $result = mysqli_query($con, $query);

    if ($result) {
        // Check if there are any matching records
        if (mysqli_num_rows($result) > 0) {
            $payment = mysqli_fetch_assoc($result);
            $sid = $payment["sid"];

            $sqlSumPaidFees = "SELECT sum(payamt) AS paid_fees FROM payment WHERE sid = '$sid' AND payment.acdyear = '$acdyear'";
            $resultSumPaidFees = mysqli_query($con, $sqlSumPaidFees);
            if (mysqli_num_rows($resultSumPaidFees) > 0) {
                while ($rows = mysqli_fetch_assoc($resultSumPaidFees)) {

                    $paidfees = $rows['paid_fees'];


                    $sqlSumTotalFees = "SELECT sum(total_fees) AS total_fees FROM acdyear WHERE sid = $sid AND acdyear.acdyear = '$acdyear'";
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
                                <title>RUDIMENT - Receipt</title>
                            </head>

                            <body>

                                <div class="buttons-container" style="display: flex; justify-content: flex-start; gap: 20px; margin-top: 1px; margin-left: 300px;">
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
                                </div>

                                <div class="container" style="margin-left:320px; margin-top:20px;">


                                    *FEES DETAILS*
                                    <br>

                                    <br>
                                    <span>Name :
                                        *<?php echo $payment['fname']; ?>
                                        <?php echo $payment['mname']; ?>
                                        <?php echo $payment['lname']; ?>*
                                    </span>
                                    <div class="classAdmitted" style="margin-top:0px;">
                                        <span>Current Class :
                                            <?php echo $payment['current_class']; ?>
                                        </span>
                                    </div>
                                    <br>
                                    _Academic Year <?php echo $acdyear; ?>_
                                    <br>

                                    <br>
                                    *FEES STATUS*
                                    <br><br>
                                    <div class="total_fees" style="margin-top:0px;">
                                        <span>Total Fees :
                                            <?php echo $totalfees; ?>
                                        </span>
                                    </div>
                                    <div class="paid_fees" style="margin-top:0px;">
                                        <span>Paid Fees :
                                            <?php echo $paidfees; ?>
                                        </span>
                                    </div>
                                    <div class="due_fees" style="margin-top:0px;">
                                        <span>*Pending Fees :
                                            <?php echo $totalfees - $paidfees; ?>*
                                        </span>
                                    </div>
                                    <br>
                                    *Payment Timeline*
                                    <br>

                                    <?php

                                    $sqlTimeline = "SELECT * FROM payment WHERE sid = $sid AND payment.acdyear = '$acdyear' ORDER BY paydate DESC";
                                    $resultTimeline = mysqli_query($con, $sqlTimeline);
                                    if (mysqli_num_rows($resultTimeline) > 0) {
                                        while ($rows = mysqli_fetch_assoc($resultTimeline)) {
                                    ?>
                                            <span>
                                                <?php echo $rows['payamt']; ?> --
                                                <?php echo $rows['paymode']; ?> --
                                                <?php echo $paydate = date('d', strtotime($rows['paydate'])); ?> -
                                                <?php echo $monthName = date('F', strtotime($rows['paydate'])); ?> -
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
                                    *RUDIMENT*
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