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
            <span style="margin-left:290px;font-size:12px;">Rudiment / <i class="fa fa-home"></i> / Complaint
                Form</span><br>
            <span style="font-size:25px;margin-left:290px;margin-top:20px;">Complaint/Feedback Form</span><br>
            <span style="margin-left:290px;margin-top:20px;font-size: 12px;">Add complaint to any student.</span>
        </div>


        <div class="addComplaintForm"
            style="width:700px;height:330px;background-color:#fff;margin-left:290px;margin-top:20px;border-radius:5px;position:absolute;">

            <div class="title" style="margin-top:10px;">
                <h3 style="margin-left:20px;">Add Complaint</h3>
            </div>
            <form action="code.php" method="POST">
                <div class="searchable-select-box" style="margin-left:20px;margin-top:0px;">

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

                    <!-- // status of complaing always new at start -->
                    <select name="comStatus" placeholder="Complaint Type"
                        style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                        <option value="New">New</option>
                        <!-- <option value="Complaint Not Selected">Select Complaint Status</option>
                    <option value="Resolve">Resolve</option>
                    <option value="Pending">Pending</option> -->
                    </select>
                </div>



                <input type="date" title="Complaint Date" name="date" placeholder="Complaint Date"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">




                <select name="comtype" placeholder="Complaint Type"
                    style="width:185px;height:30px;margin-left:20px;background-color:#fff;border-radius:5px;padding:5px;border-width:1px;margin-top:20px;">
                    <option value="Complaint Type Not Selected">Select Complaint Type</option>
                    <option value="Academic">Academic</option>
                    <option value="Care & Attention">Care & Attention</option>
                    <option value="Copy Check">Copy Check</option>
                    <option value="Foul Language">Foul Language</option>
                    <option value="Hit & Fight">Hit & Fight</option>
                    <option value="Homework">Homework</option>
                    <option value="Lunch/Water">Lunch/Water</option>
                    <option value="Photos/Videos">Photos/Videos</option>
                    <option value="Things Lost">Things Lost</option>
                    <option value="Other">Other</option>
                </select>
                <br>
                <input type="text" name="complaint" placeholder="Write Complaint"
                    style="width:400px;height:50px;margin-left:20px;background-color:#fff;border-radius:5px;padding:10px;border-width:1px;margin-top:20px;">

                <br>
                <button type="submit" name="addComplaint"
                    style="width:400px;height:35px;border-radius:5px;margin-left:20px;background-color:#ff4b4b;border:none;margin-top:20px;color:#fff;">Add
                    Complaint</button>

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