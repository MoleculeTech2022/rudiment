<?php
include 'dbcon.php';
include 'sidebar.html';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HABITUDE - Reports</title>

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

        nav {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 260px;
            padding: 20px 0;
            background-color: #fff;
            box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            margin: 0 24px;
        }

        .logo .menu-icon {
            color: #333;
            font-size: 24px;
            margin-right: 14px;
        }

        .logo .logo-name {
            color: #333;
            font-size: 22px;
            font-weight: 500;
        }

        .sidebar-content {
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 16px;
        }

        .list {
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            margin: 8px 0;
            padding: 14px 12px;
            border-radius: 8px;
            text-decoration: none;
        }

        .nav-link:hover {
            background-color: #4070f4;
        }

        .icon {
            margin-right: 14px;
            font-size: 20px;
            color: #707070;
        }

        .link {
            font-size: 16px;
            color: #707070;
            font-weight: 400;
        }

        .nav-link:hover .icon,
        .nav-link:hover .link {
            color: #fff;
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
    </style>


</head>

<body>
    <!-- Begin of Top Navbar -->
    <div class="navbar"
        style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
        <div class="title" style="margin-top: 22px;margin-left: 30px;">
            <span>FEES PAID Report</span>
        </div>
        <div class="search-bar"> <!-- Search bar code -->
            <input type="search" placeholder="Search Anything..."
                style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:200px;">
        </div>
        <div class="icons" style="margin-left:25px;margin-top:25px;">
            <i class="bx bx-bell icon notification"></i>
            <i class="bx bx-heart icon"></i>
            <i class="bx bx-mail-send icon"></i>
            <i class="bx bx-map icon"></i>
            <i class="bx bx-user icon"></i>
        </div>
        <!-- Logout Button  -->
        <div class="log-out-btn" style="margin-left: 20px; margin-top: 20px;">
            <a href="logout.php">
                <button
                    style="width: 130px; height: 30px; background-color: #ff0000; border-width: 1px; border-radius: 20px; color: #fff;">LOG-OUT</button>
            </a>
        </div>
    </div>
    <!-- End of Top Navbar -->
    <div class="dashboard-contents"
        style="margin-left:261px;width:500px;height:400px;background-color: #ffffff ;position: absolute;margin-top: 71px;">

        <table class="content-table" id="student-table" style="margin-left :30px;margin-top:20px;">
            <thead>
                <tr>
                    <th style="color: #000000;">#</th>
                    <th style="color: #000000;">Name</th>
                    <th style="color: #000000;">Total Fees</th>
                    <th style="color: #000000;">Total Paid</th>
                    <th style="color: #000000;">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // echo "ueuqiqe quiequicqh qcsyiqscguyqs qscugcqsui ";
                // $totalPaid = 0;
                $sql = "SELECT * FROM hstudents
                -- JOIN payment on students.sid = payment.sid
                JOIN hacdyear on hstudents.sid = hacdyear.sid WHERE hacdyear.acdyear ='2023-24'";
                $resultTotalFees = mysqli_query($con, $sql);
                if (mysqli_num_rows($resultTotalFees) > 0) {
                    while ($rows = mysqli_fetch_assoc($resultTotalFees)) {
                        // Caluate fees paid 
                        $student_id = $rows['sid'];
                        // echo "ueuqiqe quiequicqh qcsyiqscguyqs qscugcqsui " . $rows['sid'];
                        $sqlTotalPaid = "SELECT payamt from hpayment WHERE sid = $student_id AND acdyear = '2023-24'";
                        $resultPaidFees = mysqli_query($con, $sqlTotalPaid);
                        if (mysqli_num_rows($resultPaidFees) > 0) {
                            $totalPaid = 0;
                            while ($rowsPaidFees = mysqli_fetch_assoc($resultPaidFees)) {
                                $totalPaid += $rowsPaidFees['payamt'];
                                // $totalPaid += $rows['payamt'];
                            }
                        }

                        ?>
                        <tr>
                            <td>
                                <?= $rows['sid']; ?>
                            </td>
                            <td>
                                <?= $rows['fname']; ?>
                                <?= $rows['mname']; ?>
                                <?= $rows['lname']; ?>
                            </td>
                            <td>
                                <?= $rows['total_fees']; ?>
                            </td>
                            <td>
                                <?= $totalPaid; ?>
                            </td>
                            <td>
                                <a href="student-view.php?sid=<?= $rows['sid']; ?>" style="text-decoration:none;">
                                    <i class="bx bx-show icon"></i>
                                </a>
                                <!-- // Edit on student list  -->
                                <a href="student-edit.php?sid=<?= $rows['sid']; ?>" style="text-decoration:none;">
                                    <i class="bx bx-edit icon"></i>
                                </a>
                                <a href="student-edit.php?sid=<?= $rows['sid']; ?>" style="text-decoration:none;">
                                    <i class="bx bx-heart icon"></i>
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
</body>

</html>