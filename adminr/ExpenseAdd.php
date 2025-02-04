<?php
include "dbcon.php";
include "sidebar.html";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUDIMENT - Add Expense</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#search").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();

                $.ajax({
                    url: "paymentFilter.php",
                    method: "POST",
                    data: { search: searchText },
                    success: function (data) {
                        $("#student-table tbody").html(data);
                    }
                });
            });
        });
    </script>



</head>

<body style="background-color: #f2f4f6;">
    <div class="container">

        <div class="students-page-contents" style="margin-top:-20px;">
            <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Add
                Expense</span><br>
            <span style="font-size:25px;margin-left:290px;margin-top:20px;">Expense Add Form</span><br>
            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Add expense to any student.</span>
        </div>


        <div class="addComplaintForm"
            style="width:700px;height:230px;background-color:#fff;margin-left:290px;margin-top:20px;border-radius:5px;position:absolute;">

            <div class="title" style="margin-top:10px;">
                <h3 style="margin-left:20px;">Add Expense</h3>
            </div>
            <!-- Expense Add Form -->
            <form action="expcode.php" method="POST">

                <input type="text" name="expAmt" placeholder="Expense Amount" id="expAmt"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                <select name="expCatgId" placeholder="Monthly Fees Fetch Here" id="monthlyFees"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">
                    <option value="Not Selected">Select Expense Catgeory</option>
                    <?php
                    $sqlCategory = "SELECT * FROM expensecategory";
                    $resultCategory = mysqli_query($con, $sqlCategory);
                    if (mysqli_num_rows($resultCategory) > 0) {
                        while ($rows = mysqli_fetch_assoc($resultCategory)) {
                            ?>
                            <option value="<?= $rows['expCatgid']; ?>">
                                <?= $rows['expCatgTitle']; ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>


                <input type="date" name="expDate" placeholder="Monthly Fees Fetch Here" id="monthlyFees"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">


                <select name="expMode" placeholder="Expense Mode" id="monthlyFees"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">
                    <option value="Not Selected">Select Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Account">Account</option>

                </select>



                <input type="text" name="details" placeholder="Expense Details" id="expAmt"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">


                <br>
                <button type="submit" name="ExpenseAddBtn"
                    style="width:400px;height:35px;border-radius:5px;margin-left:20px;background-color:#ff4b4b;border:none;margin-top:20px;color:#fff;">Add
                    Expense</button>

            </form>



        </div>


    </div>


    <script>
        $(document).ready(function () {
            // Initial table load with default academic year
            <?php
            $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
            $year = mysqli_fetch_assoc($year_query);
            $default_acdyear = $year['default_acdyear'];
            ?>
            updateStudentTable("<?php echo $default_acdyear; ?>");
            // updateStudentTable("2023-24");
            // updateStudentTable("2024-25");

            function updateStudentTable(selectedYear) {
                $.ajax({
                    url: "payacdFilter.php",
                    method: "POST",
                    data: { academic_year: selectedYear },
                    success: function (data) {
                        $("#student-table tbody").html(data);
                    },
                    error: function () {
                        $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                    }
                });
            }

            // Handle academic year change
            $("#academic_year").change(function () {
                var selectedYear = $(this).val();
                updateStudentTable(selectedYear);
            });
        });


        <?php
        $year_query = mysqli_query($con, "SELECT default_acdyear FROM dacdyear");
        $year = mysqli_fetch_assoc($year_query);
        $default_acdyear = $year['default_acdyear'];
        ?>
        updateStudentTable("<?php echo $default_acdyear; ?>");
        // updateStudentTable("2023-24");
        // updateStudentTable("2024-25");

        function updateStudentTable(selectedStatus) {
            $.ajax({
                url: "modeFilter.php",
                method: "POST",
                data: { paymode: selectedStatus },
                success: function (data) {
                    $("#student-table tbody").html(data);
                },
                error: function () {
                    $("#student-table tbody").html('<tr><td colspan="6">Error loading data.</td></tr>');
                }
            });
        }


        $("#status").change(function () {
            var selectedStatus = $(this).val();
            updateStudentTable(selectedStatus);
        });

    </script>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <!-- Include Chosen jQuery plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <!-- Include Chosen CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <!-- Initialize Chosen on the 'search' select element -->
    <script>
        $('#fetch').chosen();
    </script>

</body>

</html>