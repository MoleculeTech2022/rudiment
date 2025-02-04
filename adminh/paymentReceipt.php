<?php
include "dbcon.php";
include "sidebar.html";

// Get payment id from payments page
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
            $payment = mysqli_fetch_assoc($result);
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
                    *Payment Update*
                    <br><br>

                    <span>Name :
                        <?php echo $payment['fname']; ?>
                        <?php echo $payment['mname']; ?>
                        <?php echo $payment['lname']; ?>
                    </span>
                    <br>
                    <div class="classAdmitted" style="margin-top:10px;">
                        <span>Class :
                            <?php echo $payment['classAdmitted']; ?>

                        </span>
                    </div>
                    <br>
                    <div class="Amount" style="margin-top:10px;">
                        <span>Amount :
                            <?php echo $payment['payamt']; ?>

                        </span>
                    </div>
                    <div class="Date" style="margin-top:10px;">
                        <span>Date :
                            <?php echo $payment['paydate']; ?>

                        </span>
                    </div>
                    <div class="Mode" style="margin-top:10px;">
                        <span>Mode :
                            <?php echo $payment['paymode']; ?>

                        </span>
                    </div>
                    <br>
                    Thanks
                    <br>
                    *Management*
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
?>