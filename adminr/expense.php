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
                    <title>RUDIMENT - Expense</title>

                    <!-- // boxicons icon link cdn -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/boxicons.min.css">


                    <!-- // fontawesome css link -->
                    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

                        .long-text {
                            word-wrap: break-word;
                            /* or use overflow-wrap: break-word; */
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
                            <span style="margin-left:290px;font-size:12px;">Rudiment >> <i class="fa fa-home"></i> >>
                                Expense</span><br>
                            <span style="font-size:35px;margin-left:290px;margin-top:20px;">Expense List</span><br>
                            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">All Rudiment Expense manage here.</span>

                        </div>
                        <div class="buttons" style="margin-left:990px;margin-top:-90px;">
                            <a href="ExpenseAdd.php" style="text-decoration:none;">
                                <button
                                    style="height:40px;width:100px;margin-top:20px;margin-left:-10px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                                    Expense</button>
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
                            style="position:absolute;width:150px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;">

                            <div class="titile" style="margin-top:5px;">
                                <span style="margin-left:10px;margin-top:-20px;">Cash Out</span>

                            </div>

                            <h3 style="margin-left:10px;margin-top:10px;">
                                <?php
                                $sqlSumCashOut = "SELECT SUM(expAmt) AS TotalCashOut FROM expense";
                                $resultSumCashOut = mysqli_query($con, $sqlSumCashOut);
                                if (mysqli_num_rows($resultSumCashOut) > 0) {
                                    while ($rows = mysqli_fetch_assoc($resultSumCashOut)) {
                                        $totalCashOut = $rows['TotalCashOut'];
                                        echo $totalCashOut;
                                    }
                                }

                                ?>
                            </h3><br>

                        </div>
                        <div class="second-card"
                            style="position:absolute;width:150px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left:170px;">

                            <div class="titile" style="margin-top:5px;">
                                <span style="margin-left:10px;margin-top:-20px;">Cash In</span>

                            </div>

                            <h3 style="margin-left:10px;margin-top:10px;">
                                <?php
                                $sqlSumCashIn = "SELECT SUM(payamt) AS TotalCashIn FROM payment";
                                $resultSumCashIn = mysqli_query($con, $sqlSumCashIn);
                                if (mysqli_num_rows($resultSumCashIn) > 0) {
                                    while ($rows = mysqli_fetch_assoc($resultSumCashIn)) {
                                        $totalCashIn = $rows['TotalCashIn'];
                                        echo $totalCashIn;
                                    }
                                }
                                ?>
                            </h3><br>

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
                                        <th>Category</th>
                                        <th>Amt</th>
                                        <th>Date</th>
                                        <th>Mode</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sqlFetchStudents = "SELECT * FROM expense
                                    JOIN expensecategory ON expense.expCatgid = expensecategory.expCatgid
                                    ORDER BY expense.expid DESC";
                                    $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);
                                    $count = 0;

                                    if (mysqli_num_rows($resultFetchStudents) > 0) {
                                        while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {

                                            $email = "";

                                            ?>
                                            <tr>

                                                <td style="color:#000;">
                                                    <?php
                                                    echo $count + 1;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="student-view.php?sid=<?php echo $rows['expid']; ?>"
                                                        style="text-decoration: none;color:#000;">
                                                        <span style="font-size:15px ;">
                                                            <?php echo $rows['expCatgTitle']; ?>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $rows['expAmt']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['expDate']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['expMode']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $rows['details']; ?>
                                                </td>

                                                <td>
                                                    <a href="student-view.php?expid<?php echo $rows['expid']; ?>" style="text-decoration:none;">
                                                        <i class="bx bx-id-card" style="margin-left:15px;"></i>
                                                    </a>
                                                    <a href="exp_edit.php?expid=<?php echo $rows['expid']; ?>" style="text-decoration:none;">
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