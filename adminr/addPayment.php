<?php
include "dbcon.php";
include "sidebar.html";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUDIMENT - Payments</title>

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
            <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Payments
                Form</span><br>
            <span style="font-size:35px;margin-left:290px;margin-top:20px;">Payments Form</span><br>
            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">All payment to any student.</span>
        </div>


        <div class="addPaymentForm"
            style="width:700px;height:330px;background-color:#fff;margin-left:290px;margin-top:20px;border-radius:5px;position:absolute;">

            <div class="title" style="margin-top:10px;">
                <span style="margin-left:20px;">Make Payment</span>
            </div>
            <form action="code.php" method="POST">
                <div class="searchable-select-box" style="margin-left:20px;margin-top:20px;">

                    <?php
                    // Execute a SQL query to select student names from the database
                    $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM students");
                    echo "<select required id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                    echo "<option>Select Student</option>";
                    while ($row = mysqli_fetch_array($direct)) {
                        echo "<option value='" . $row['sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>

                <input type="number" required name="payamt" placeholder="Amount"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">

                <input type="date" required title="Payment Date" name="paydate" placeholder="Payment Date"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                <br>

                <select name="paymode" required placeholder="Payment Mode"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                    <option value="Payment Not Selected">Select Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Account">Account</option>
                </select>
                <select name="acdyear" required placeholder="Academic Year"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                    <option value="2023-24">2023-24</option>
                    <option value="2022-23">2022-23</option>
                </select>
                <br>
                <select name="feestitle" required placeholder="Select Fees Title"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                    <option value="Tuition Fee">Tuition Fee</option>
                    <option value="Registration Fee">Registration Fee</option>
                    <option value="Other Fee">Other Fee</option>
                </select>
                <br>
                <button type="submit" name="update_payment"
                    style="width:300px;height:35px;border-radius:5px;margin-left:20px;background-color:#ffe030;border:none;margin-top:20px;">Make
                    Payment</button>

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