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
                Temporary</span><br>
            <span style="font-size:25px;margin-left:290px;margin-top:20px;">Temporary Work Add Form</span><br>
            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Add temporary work to any student.</span>
        </div>


        <div class="addComplaintForm"
            style="width:700px;height:270px;background-color:#fff;margin-left:290px;margin-top:20px;border-radius:5px;position:absolute;">

            <div class="title" style="margin-top:10px;">
                <h3 style="margin-left:20px;">Add Temporary</h3>
            </div>
            <!-- Expense Add Form -->
            <form action="expcode.php" method="POST">

                <br>

                <div class="searchable-select-box" style="margin-left:20px;margin-top:-8px;">

                    <?php
                    // Execute a SQL query to select student names from the database
                    $direct = mysqli_query($con, "SELECT `sid`, fname, mname, lname FROM students");
                    echo "<select id='fetch' name='sid' onchange='redirectToStudentView(this.value)'>";
                    echo "<option>Select Student</option>";
                    while ($row = mysqli_fetch_array($direct)) {
                        echo "<option value='" . $row['sid'] . "'>" . $row['sid'] . ". " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>

                <input type="text" name="text_one" placeholder="Text One"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">



                <input type="text" name="text_two" placeholder="Text Two" id="monthlyFees"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">


                <input type="text" name="text_three" placeholder="Text Three" id="monthlyFees"
                    style="width:220px;height:35px;border-radius:2px;background-color:#f9f5f5;color:#000;padding:5px;outline:none;border-width:1px;margin-left:20px;margin-top:15px;">

                <br>
                <button type="submit" name="add_temp_btn"
                    style="width:400px;height:35px;border-radius:5px;margin-left:20px;background-color:#ff4b4b;border:none;margin-top:20px;color:#fff;">Add
                    Work</button>

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