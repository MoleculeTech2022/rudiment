<?php
require 'dbcon.php';
include "checklogin.php";

// Initialize an empty array to store the options
$options = [];

// Query to fetch data from the database
$query = "SELECT sid, CONCAT(fname, ' ', mname, ' ', lname) AS full_name FROM students";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each option to the array
        $options[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Sidebar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                    url: "payhis_search.php", // Create a PHP script for filtering
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
    <div class="container">
        <?php
        include "sidebar.html";
        ?>
        <div class="navbar"
            style="margin-left:261px;width:80%;height: 70px;position: absolute;background-color: rgb(241, 246, 251);display: flex;">
            <div class="title" style="margin-top: 22px;margin-left: 30px;">
                <span>Expense</span>
            </div>
            <div class="search-bar">
                <input type="search" placeholder="Search Your Student..." id="search" name="search"
                    style="width:300px;height:35px;margin-top:17px;border: none;border-radius: 20px;padding:10px;margin-left:240px;">
            </div>
            <div class="icons" style="margin-left:25px;margin-top:25px;">

                <a href="admission.php"><i class='bx bx-message-square-add icon'></i></a>
            </div>
            <div class="log-out-btn" style="margin-left:10px;margin-top:20px;">
                <button
                    style="width:130px;height: 30px;background-color:#ff0000;border-width: 1px;border-radius: 20px;">LOG-OUT</button>
            </div>
        </div>
        <!-- Main Content of Page  -->
        <div class="dashboard-contents"
            style="margin-left:261px;width:900px;height:700px;background-color: #ffffff ;position: absolute;margin-top: 71px;">
            <!-- Add Expense Form -->
            <div>
                <h4 style="margin-left:30px;margin-top:10px;">Add Expense Form</h4>
                <div class="select-student-form">
                    <form action="code.php" method="POST">
                        <select name="expCatgid" placeholder="Your Amount"
                            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <?php
                            $sqlCatgid = "SELECT expCatgid,expCatgTitle FROM expensecategory";
                            $catgidResult = mysqli_query($con, $sqlCatgid);
                            if (mysqli_num_rows($catgidResult) > 0) {
                                while ($rows = mysqli_fetch_assoc($catgidResult)) {
                                    ?>
                                    <option value='<?php echo $rows["expCatgid"]; ?>'>
                                        <?php echo $rows['expCatgTitle']; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="text" name="expamt" id="expamt" placeholder="Your Expense Amount"
                            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">

                        <select name="expmode" placeholder="Your ExAmt Mode"
                            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <option value="Not Selected">Select Payment Mode</option>
                            <option value="Cash">Cash</option>
                            <option value="Account">Account</option>
                        </select>

                        <select name="acdyear" placeholder="Your Amount Date"
                            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">
                            <option value="2023-24">2023-24</option>
                            <option value="2022-23">2022-23</option>
                            <option value="2024-25">2024-25</option>
                        </select>

                        <input type="text" name="expdate" id="expdate" placeholder="Your Expense Date"
                            style="margin-left:30px;margin-top:20px;padding:5px;width:210px;border-radius:5px;border-width:1px;">


                        <div class="payment-update-btn"
                            style="margin-left:30px;margin-top:25px;margin-bottom:20px;height:300px;">
                            <button class="payment-update-btn" id="refreshButton" value="submit" name="add_expense"
                                style="width:280px;height:35px;border-radius:5px;background-color:#00eaff;border-width:1px;"
                                id="refreshButton">Add Expense</button>
                            <h4 style="margin-top:20px;">Expense List</h4>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Display Expense  -->
            <div>
                <table class="content-table" id="student-table" style="margin-left :30px;margin-top:-230px;">
                    <thead>
                        <tr>
                            <th style="color: #000000;">#</th>
                            <th style="color: #000000;">Title</th>
                            <th style="color: #000000;">Amt</th>
                            <th style="color: #000000;">Date</th>
                            <th style="color: #000000;">Mode</th>
                            <th style="color: #000000;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        $sqlExpense = "SELECT * FROM expense JOIN expensecategory ON expense.expcatgid = expensecategory.expCatgid";
                        $resultExpense = mysqli_query($con, $sqlExpense);
                        if (mysqli_num_rows($resultExpense) > 0) {
                            while ($rowsExpense = mysqli_fetch_assoc($resultExpense)) {
                                ?>

                                <tr>
                                    <td>
                                        <?= $count++ ?>
                                    </td>
                                    <td>
                                        <?= $rowsExpense['expCatgTitle'] ?>
                                    </td>
                                    <td>
                                        <?= $rowsExpense['expamt'] ?>
                                    </td>
                                    <td>
                                        <?= $rowsExpense['expdate'] ?>
                                    </td>
                                    <td>
                                        <?= $rowsExpense['expmode'] ?>
                                    </td>
                                    <td>
                                        <a href="exp_edit.php?expCatgid=<?= $rowsExpense['expCatgid']; ?>">
                                            Edit
                                        </a>
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


    <!-- // function updateStudentTable(selectedYear) {
    //       $.ajax({
    //           url: "ayear.php",
    //           method: "POST",
    //           data: { academic_year: selectedYear },
    //           success: function (data) {
    //               $("#student-table tbody").html(data);
    //           },
    //           error: function () {
    //               $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
    //           }
    //       });
    //   } -->
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

    <!-- ajax call script -->
    <script>
        $(document).ready(function () {
            // Initial table load with default academic year
            updateStudentTable("2024-25");
            updateStudentTable("2023-24");

            // Handle academic year change
            $("#academic_year").change(function () {
                var selectedYear = $(this).val();
                updateStudentTable(selectedYear);
            });
        });

        // Add search functionality using jQuery
        // Initialize Select2
        $("#studentSelect").select2();

        // Live search functionality
        $("#studentSelect").select2({
            minimumInputLength: 1,
            ajax: {
                url: "search.php", // Create a separate PHP file for handling AJAX requests
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // Search term entered by the user
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


    </script>



</body>

</html>