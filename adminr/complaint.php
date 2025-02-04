<?php
include 'dbcon.php';
include 'sidebar.html';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUDIMENT - Complaints</title>
    <!-- // jQuery cdn link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- // search filter script -->
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                    url: "complaintFilter.php",
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
        body {
            background-color: #f2f4f6;
        }

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

        .solved-status {
            color: rgb(4, 218, 32);
        }

        .pending-status {
            color: #eea435;
        }
    </style>

</head>

<body>
    <div class="complaint-container">

        <div class="complaint-page-contents" style="margin-top:-20px;">
            <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Complaint</span><br>
            <span style="font-size:35px;margin-left:290px;margin-top:20px;">Complaints</span><br>
            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">All Rudiment complaints manage here.</span>
        </div>

        <div class="buttons" style="margin-left:990px;margin-top:-90px;">
            <a href="addComplaint.php" style="text-decoration:none;">
                <button id="addComButton"
                    style="height:40px;width:120px;margin-top:20px;margin-left:120px;background-color:rgb(50, 61, 77);color:#fff;border:none;border-radius: 5px;">Add
                    Complaint</button>
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


        <div class="total-class-wise-details" style="margin-left:910px;margin-top:-60px;">


            <div class="first-card"
                style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left:-130px;">
                <h3 style="margin-left:25px;margin-top:10px;">
                    <?php

                    $sqlSolved = "SELECT count(comStatus) AS totalSolved FROM complaint WHERE comStatus = 'Resolved'";
                    $resultSolved = mysqli_query($con, $sqlSolved);
                    if (mysqli_num_rows($resultSolved) > 0) {
                        while ($rowSolved = mysqli_fetch_assoc($resultSolved)) {
                            $totalSolved = $rowSolved["totalSolved"];
                            // Use str_pad to format the count as a two-digit number
                            $formattedCount = str_pad($totalSolved, 2, '0', STR_PAD_LEFT);
                            echo $formattedCount;
                        }
                    }

                    ?>
                </h3><br>
                <div class="titile" style="margin-top:-20px;">
                    <span style="margin-left:25px;margin-top:-20px;">Resolved</span>

                </div>
            </div>

            <div class="second-card"
                style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left:27px;">
                <h3 style="margin-left:30px;margin-top:10px;">
                    <?php
                    $sqlPending = "SELECT count(comStatus) AS totalPending FROM complaint WHERE comStatus = 'In Progress'";
                    $resultPending = mysqli_query($con, $sqlPending);
                    if (mysqli_num_rows($resultPending) > 0) {
                        while ($rowPending = mysqli_fetch_assoc($resultPending)) {
                            $totalPending = $rowPending["totalPending"];
                            // Use str_pad to format the count as a two-digit number
                            $formattedCount = str_pad($totalPending, 2, '0', STR_PAD_LEFT);
                            echo $formattedCount;
                        }
                    }
                    ?>

                </h3><br>
                <div class="titile" style="margin-top:-20px;">
                    <span style="margin-left:30px;margin-top:-20px;">In Progress</span>

                </div>
            </div>

            <div class="third-card"
                style="position:absolute;width:140px;height:80px;background-color: #fff;box-shadow:1px 1px 1px 1px #edeaea;border-radius: 5px;margin-left: 180px;">
                <h3 style="margin-left:30px;margin-top:10px;">
                    <?php echo $totalSolved + $totalPending; ?>
                </h3><br>
                <div class="titile" style="margin-top:-20px;">
                    <span style="margin-left:25px;margin-top:-20px;">Total</span>

                </div>
            </div>
        </div>

        <div class="student-list-table"
            style="width:930px;margin-left: 290px;background-color: #fff;border-radius: 10px;height: 600px;margin-top: 100px;">
            <div class="table-header">

                <select name="status" id="status"
                    style="width:130px;height:35px;margin-left:30px;margin-top:20px;padding: 5px;border-color: #edeaea;border-radius: 5px;">
                    <option>Status Filter</option>
                    <option value="Solved">Solved</option>
                    <option value="Pending">Pending</option>
                </select>
                <a href="logout.php">
                    <button
                        style="height:30px;width:70px;margin-top:20px;margin-left:10px;background-color:rgb(250, 174, 93);color:#fff;border:none;border-radius: 5px;">Apply</button>
                </a>

                <hr style="margin-top: 15px;color: #ffffff;">
            </div>
            <div class="table" id="student-table" style="margin-left: 30px;;">

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Complaint</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlFetchStudents = "SELECT * FROM complaint 
                        JOIN students ON students.sid = complaint.sid
                        ORDER BY cfid DESC";
                        $resultFetchStudents = mysqli_query($con, $sqlFetchStudents);

                        if (mysqli_num_rows($resultFetchStudents) > 0) {
                            while ($rows = mysqli_fetch_assoc($resultFetchStudents)) {

                                $email = $rows['email'];

                                $status = $rows['comStatus'];
                                $rowClass = '';

                                // Check comStatus and assign the appropriate CSS class
                                if ($status == 'Resolved') {
                                    $rowClass = 'solved-status';
                                } elseif ($status == 'In Progress') {
                                    $rowClass = 'pending-status';
                                }

                                ?>
                                <tr>

                                    <td><input type="checkbox"></td>
                                    <td>
                                        <?php echo $rows['date']; ?>
                                    </td>

                                    <td>
                                        <a href="#" class="student-name-link" data-sid="<?php echo $rows['sid']; ?>"
                                            style="text-decoration: none;color:#000;">
                                            <span style="font-size:15px;">
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
                                        <?php echo $rows['comtype']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $complaint = $rows['complaint'];
                                        $words = explode(' ', $complaint);
                                        $limitedComplaint = implode(' ', array_slice($words, 0, 3)); // Limiting to 10 words
                                        echo $limitedComplaint;

                                        echo '...'; // Add an ellipsis if there are more words
                                        ?>
                                    </td>
                                    <td class="<?php echo $rowClass; ?>">
                                        <?php echo $rows['comStatus']; ?>
                                    </td>

                                    <td>
                                        <a href=" payment_due.php?sid=<?php echo $rows['sid']; ?>"
                                            style="text-decoration:none;">
                                            <i class="fa fa-ellipsis-v" style="margin-left:15px;"></i>
                                        </a>
                                        <a href="viewComplaint.php?cfid=<?php echo $rows['cfid']; ?>"
                                            style="text-decoration:none;">
                                            <i class="fa fa-edit" style="margin-left:15px;"></i>
                                        </a>
                                        <!-- <a href="student-edit.php?sid=<?php echo $rows['sid']; ?>">
                                            <i class="fa fa-camera" style="margin-left:15px;"></i>
                                        </a> -->
                                    </td>
                                </tr>

                                <?php
                            }
                        }

                        ?>
                    </tbody>
                </table>

            </div>

        </div>



    </div>




    <script>
        function updateStudentTable(selectedStatus) {
            $.ajax({
                url: "comFilter.php",
                method: "POST",
                data: { comStatus: selectedStatus },
                success: function (data) {
                    $("#student-table tbody").html(data);
                },
                error: function () {
                    $("#student-table tbody").html('<tr><td colspan="7">Error loading data.</td></tr>');
                }
            });
        }

        $("#status").change(function () {
            var selectedStatus = $(this).val();
            updateStudentTable(selectedStatus);
        });
    </script>




</body>

</html>