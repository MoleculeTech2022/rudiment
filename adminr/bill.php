<?php

// include database connection
include "dbcon.php";

if (isset($_GET['sid'])) {

    // student id received here
    $sid = mysqli_real_escape_string($con, $_GET['sid']);
    $acdyear = mysqli_real_escape_string($con, $_GET['acdyear']);

    $total_fees_global = 0;

    // Fetch student details
    $bill_sql = "SELECT * FROM students
                 JOIN acdyear ON acdyear.sid = students.sid
                 WHERE students.sid = '$sid' AND acdyear.acdyear = '$acdyear'";
    $bill_run = mysqli_query($con, $bill_sql);

    if ($bill_run && mysqli_num_rows($bill_run) == 1) {
        $student = mysqli_fetch_assoc($bill_run);
        $admission_number = 'RISP' . str_pad($student['sid'], 5, '0', STR_PAD_LEFT);
        $total_fees_global = $student['total_fees'];

        $registration_fee = 2000;
        $exam_fee = 235;
        $tuition_fee = $total_fees_global - 4090;
        $dress_fee = 1855;
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Receipt</title>
        <style>
            table {
                width: 50%;
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }
        </style>
        <script>
            function printReceipt() {
                var printContents = document.getElementById('receipt-form').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    </head>

    <body>
        <center>
            <button onclick="printReceipt()" style="width:90px;height:40px;background-color:#2a8dff;color:#fff;border-radius:5px;border: none;">
                Print Receipt
            </button>
        </center>
        <div class="container" style="margin-top:10px;">
            <div class="receipt-container" style="margin-left: 300px;">
                <div class="receipt-form" id="receipt-form" style="width:600px;height:1000px;background-color: rgb(250, 247, 247);border-radius: 10px;">
                    <div class="receipt-header" style="width:600px;height: 100px;">
                        <div class="receipt-rudiment-logo" style="display:flex;">
                            <img src="rudiment_logo.png" style="width:100px;height:100px;">
                            <h2 style="color: #30D5C8;">RUDIMENT PRE-PRIMARY SCHOOL</h2>
                        </div>
                        <h3 style="color: #000;margin-left:130px;margin-top:-40px;"> Sr. NO 16, Hingde Wasti, Maan, PUNE-411057</h3>
                        <h3 style="color: #000;margin-left:220px;margin-top:-12px;">Academic Year <?= $acdyear?></h3>
                    </div>
                    <div class="heading" style="width:600px;height:40px;background:#30D5C8;margin-top:20px;position:absolute;">
                        <div class="title" style="margin-top:10px;">
                            <h3 style="color:#fff;margin-left:205px;margin-top:10px;">SCHOOL FEES RECEIPT</h3>
                        </div>
                    </div>
                    <div class="receipt-body">
                        <div class="heading_two" style="display:flex;">
                            <h4 style="margin-top:73px;margin-left:20px;">Sr No. ______________</h4>
                            <h4 style="margin-top:73px;margin-left:220px;">Date : <?= date('d F Y'); ?></h4>
                        </div>
                        <hr style="margin-top:-10px;">
                        <div class="receipt-details" style="display: flex;">
                            <h4 style="margin-top:8px;margin-left:20px;">Student Name : <?= $student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname']; ?></h4>
                            <h4 style="margin-top:8px;margin-left:105px;">Adm No. <?= $admission_number; ?></h4>
                        </div>
                        <div class="receipt-details" style="display: flex;margin-top:-10px;">
                            <h4 style="margin-top:13px;margin-left:20px;">Class : <?= $student['current_class'] ?></h4>
                            <h4 style="margin-top:13px;margin-left:40px;">Section : A</h4>
                            <h4 style="margin-top:13px;margin-left:40px;">Roll No : _______ </h4>
                            <h4 style="margin-top:13px;margin-left:50px;">Student ID : <?= $student['sid']; ?></h4>
                        </div>
                        <hr style="margin-top:5px;">
                        <div class="receipt-details" style="display: flex;margin-top:5px;">
                            <h4 style="margin-top:13px;margin-left:20px;">Total Fees for this Academic Year : ₹ <?= $total_fees_global; ?></h4>
                        </div>
                        

                        <div class="table_title" style="display: flex;margin-left:20px;margin-top:5px;">
                            <table style="width:530px;margin-left:10px;">
                                <tr>
                                    <th>#</th>
                                    <th style="width:300px;">Fees Title</th>
                                    <th>Amount</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Registration</td>
                                    <td><?= $registration_fee; ?></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tuition Fee</td>
                                    <td><?= $tuition_fee; ?></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Exam Fee</td>
                                    <td><?= $exam_fee; ?></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Sports Fee</td>
                                    <td><?= 0; ?></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Dress</td>
                                    <td><?= $dress_fee; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="title" style="margin-left:20px;">
                        <br>
                        <hr>
                        <h3>Total Fees Paid By Now :  
                        
                                    <?php
                                    $sql_two = "SELECT SUM(payamt) AS total_payment FROM payment WHERE sid = '$sid' AND acdyear = '$acdyear'";
                                    $run_two = mysqli_query($con, $sql_two);
                                    $total_payment = 0;
                                    if ($run_two && mysqli_num_rows($run_two)) {
                                        $rows_two = mysqli_fetch_assoc($run_two);
                                        $total_payment = $rows_two['total_payment'];
                                        echo $total_payment;
                                    }
                                    ?>
                                </h3>
                                </div>

                        <div class="payment-timeline">
                            <div class="title" style="margin-left:20px;">
                                
                                <h3>Payment Timeline</h3>
                            </div>
                            <div class="payment-timeline-text">
                                <?php
                                $sql = "SELECT * FROM payment WHERE sid = '$sid' AND acdyear = '$acdyear' ORDER BY payid DESC";
                                $run = mysqli_query($con, $sql);
                                if ($run && mysqli_num_rows($run)) {
                                    while ($rows = mysqli_fetch_assoc($run)) {
                                        ?>
                                        <div class="payment-text" style="margin-top:5px;">
                                            <span>
                                                <span style="margin-left:20px;">Amount : <?= $rows['payamt']; ?></span>
                                                <span style="margin-left:20px;">Date : <?= $rows['paydate']; ?></span>
                                                <span style="margin-left:20px;">Mode : <?= $rows['paymode']; ?></span>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="reciept-footer">
                            <div class="balance-div" style="margin-top: 60px;display:flex;">
                            <h3 style="margin-left:20px; color: red;">Balance(Due) : ₹ <?= $total_fees_global - $total_payment; ?></h3>
                                <h3 style="margin-left:220px;">Stamp & Sign</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

    <?php
    }
}
?>
